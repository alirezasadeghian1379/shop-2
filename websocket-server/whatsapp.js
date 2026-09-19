const fs = require('fs')
const path = require('path')
const QRCode = require('qrcode')
const pino = require('pino')
const { ProxyAgent } = require('proxy-agent')
const {
    DisconnectReason,
    downloadMediaMessage,
    fetchLatestBaileysVersion,
    makeCacheableSignalKeyStore,
    useMultiFileAuthState,
} = require('@whiskeysockets/baileys')

class WhatsAppBridge {
    constructor(config) {
        this.config = config
        this.authDir = path.resolve(config.WHATSAPP_AUTH_DIR || path.join(__dirname, 'storage/whatsapp-auth'))
        this.logger = pino({ level: config.IS_DEVELOPMENT ? 'info' : 'silent' })
        this.socket = null
        this.connecting = null
        this.status = 'disconnected'
        this.qr = null
        this.phone = null
    }

    snapshot() {
        return {
            status: this.status,
            qr: this.qr,
            phone: this.phone,
        }
    }

    async connect() {
        if (this.socket || this.connecting) return this.snapshot()

        this.status = 'connecting'
        this.connecting = this.createSocket()

        try {
            await this.connecting
        } finally {
            this.connecting = null
        }

        return this.snapshot()
    }

    async createSocket() {
        fs.mkdirSync(this.authDir, { recursive: true })
        const { state, saveCreds } = await useMultiFileAuthState(this.authDir)
        const { version } = await fetchLatestBaileysVersion()
        const { default: makeWASocket } = await import('@whiskeysockets/baileys')
        const proxyAgent = this.config.WHATSAPP_PROXY_URL
            ? new ProxyAgent({ getProxyForUrl: () => this.config.WHATSAPP_PROXY_URL })
            : undefined

        const socket = makeWASocket({
            version,
            auth: {
                creds: state.creds,
                keys: makeCacheableSignalKeyStore(state.keys, this.logger),
            },
            logger: this.logger,
            printQRInTerminal: false,
            markOnlineOnConnect: false,
            syncFullHistory: false,
            agent: proxyAgent,
            fetchAgent: proxyAgent,
        })

        this.socket = socket
        socket.ev.on('creds.update', saveCreds)
        socket.ev.on('connection.update', update => this.onConnectionUpdate(socket, update))
        socket.ev.on('messages.upsert', event => this.onMessages(socket, event))
    }

    async onConnectionUpdate(socket, { connection, lastDisconnect, qr }) {
        if (socket !== this.socket) return

        if (qr) {
            this.qr = await QRCode.toDataURL(qr, { width: 320, margin: 2 })
            this.status = 'qr'
        }

        if (connection === 'open') {
            this.status = 'connected'
            this.qr = null
            this.phone = socket.user?.id?.split(':')[0]?.split('@')[0] || null
        }

        if (connection === 'close') {
            const statusCode = lastDisconnect?.error?.output?.statusCode
            const loggedOut = statusCode === DisconnectReason.loggedOut
            this.socket = null
            this.qr = null
            this.phone = null
            this.status = loggedOut ? 'disconnected' : 'reconnecting'

            if (loggedOut) {
                fs.rmSync(this.authDir, { recursive: true, force: true })
            } else {
                setTimeout(() => this.connect().catch(error => this.logger.error(error)), 2000)
            }
        }
    }

    async onMessages(socket, { messages, type }) {
        if (type !== 'notify' || !this.config.WHATSAPP_WEBHOOK_URL) return

        for (const item of messages) {
            const jid = item.key.remoteJid
            if (item.key.fromMe || !jid || jid.endsWith('@g.us') || jid === 'status@broadcast') continue

            let senderJid = item.key.remoteJidAlt || jid

            if (senderJid.endsWith('@lid')) {
                senderJid = await socket.signalRepository.lidMapping.getPNForLID(senderJid)
            }

            if (!senderJid || !senderJid.endsWith('@s.whatsapp.net')) {
                this.logger.warn({ jid }, 'Could not resolve WhatsApp LID to a phone number')
                continue
            }

            const senderNumber = senderJid
                .replace('@s.whatsapp.net', '')
                .split(':')[0]

            const imageMessage = item.message?.imageMessage
            const videoMessage = item.message?.videoMessage
            const mediaMessage = imageMessage || videoMessage
            const message = item.message?.conversation
                || item.message?.extendedTextMessage?.text
                || mediaMessage?.caption

            if (!message && !mediaMessage) continue

            try {
                let mediaBase64 = null
                if (mediaMessage) {
                    const mediaBuffer = await downloadMediaMessage(
                        item,
                        'buffer',
                        {},
                        { logger: this.logger, reuploadRequest: socket.updateMediaMessage }
                    )
                    mediaBase64 = mediaBuffer.toString('base64')
                }

                const response = await fetch(this.config.WHATSAPP_WEBHOOK_URL, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        ID: item.key.id,
                        Type: mediaMessage ? 'file' : 'chat',
                        From: senderNumber,
                        To: socket.user?.id?.split(':')[0]?.split('@')[0] || '',
                        Chat: message || null,
                        Caption: mediaMessage?.caption || null,
                        MediaType: imageMessage ? 'image' : (videoMessage ? 'video' : null),
                        MediaMime: mediaMessage?.mimetype || null,
                        MediaName: mediaMessage?.fileName || null,
                        MediaBase64: mediaBase64,
                        createdAt: String(item.messageTimestamp || ''),
                        dataType: 'message',
                        Hash: null,
                        GroupId: null,
                    }),
                })
                const responseBody = await response.text()
                let payload

                try {
                    payload = JSON.parse(responseBody)
                } catch {
                    throw new Error(`Webhook returned a non-JSON response (HTTP ${response.status})`)
                }

                if (!response.ok) {
                    const message = payload.message
                        || payload.data?.message
                        || `Webhook request failed (HTTP ${response.status})`
                    throw new Error(message)
                }

                // The existing Laravel webhook sends its response through
                // MessengerService. Custom handlers may delegate it to Bridge.
                if (typeof payload.reply === 'string' && payload.reply.trim() !== '') {
                    await socket.sendMessage(jid, { text: payload.reply })
                }
            } catch (error) {
                this.logger.error(error, 'WhatsApp webhook failed')
            }
        }
    }

    async disconnect() {
        const socket = this.socket
        this.socket = null
        this.status = 'disconnected'
        this.qr = null
        this.phone = null

        if (socket) await socket.logout().catch(() => socket.end())
        fs.rmSync(this.authDir, { recursive: true, force: true })

        return this.snapshot()
    }

    async sendMessage(number, message = '', mediaType = null, mediaBuffer = null, mediaMime = null, mediaName = null) {
        if (this.status !== 'connected' || !this.socket) {
            throw new Error('WhatsApp is not connected')
        }

        let normalizedNumber = String(number).replace(/\D/g, '')

        if (normalizedNumber.startsWith('00')) {
            normalizedNumber = normalizedNumber.slice(2)
        } else if (normalizedNumber.startsWith('0')) {
            normalizedNumber = `98${normalizedNumber.slice(1)}`
        }

        if (!normalizedNumber) {
            throw new Error('Phone number is required')
        }

        const jid = `${normalizedNumber}@s.whatsapp.net`
        const caption = typeof message === 'string' ? message.trim() : ''

        let content

        if (mediaType === 'image') {
            if (!mediaBuffer || !Buffer.isBuffer(mediaBuffer)) {
                throw new Error('Image data is required')
            }

            content = {
                image: mediaBuffer,
                caption,
                mimetype: mediaMime || 'image/jpeg',
            }
        } else if (mediaType === 'video') {
            if (!mediaBuffer || !Buffer.isBuffer(mediaBuffer)) {
                throw new Error('Video data is required')
            }

            content = {
                video: mediaBuffer,
                caption,
                mimetype: mediaMime || 'video/mp4',
                fileName: mediaName || undefined,
            }
        } else {
            if (caption === '') {
                throw new Error('Message is required when no media is provided')
            }

            content = {
                text: caption,
                linkPreview: null,
            }
        }

        const result = await this.socket.sendMessage(jid, content)

        return {
            status: 'sent',
            id: result?.key?.id || null,
            number: normalizedNumber,
            media_type: mediaType,
            media_mime: mediaMime,
            media_name: mediaName,
        }
    }
}

module.exports = WhatsAppBridge
