const WebSocket = require('ws')
const { spawn } = require('child_process')
const fs = require('fs')
const path = require('path')
const config = require('./config/app')
const AsyncLock = require('async-lock')
const lock = new AsyncLock()
const express = require('express')
const app = express()
app.use(express.json({ limit: '70mb' }))
const WhatsAppBridge = require('./whatsapp')
const whatsapp = new WhatsAppBridge(config)


const PORT = Number(config.PORT || 62111)

const wss = new WebSocket.Server({
    port: PORT,
})

const streams = {}

const waitForHls = (filePath, timeout = 15000) => {
    return new Promise((resolve, reject) => {
        const start = Date.now()

        const timer = setInterval(() => {
            try {
                if (fs.existsSync(filePath)) {
                    const content = fs.readFileSync(filePath, 'utf8')

                    const hasSegment =
                        content.includes('#EXTINF') &&
                        content.includes('.ts')

                    if (hasSegment) {
                        clearInterval(timer)
                        resolve(true)
                    }
                }
            } catch {}

            if (Date.now() - start > timeout) {
                clearInterval(timer)
                reject(new Error('NO SEGMENT'))
            }
        }, 200)
    })
}

function stopStream(cameraId) {
    const stream = streams[cameraId]
    if (!stream) return

    if (stream._closing) return
    stream._closing = true

    console.log('[STOP STREAM]', cameraId)

    stream.viewers = new Set()

    try {
        if (stream.process && !stream.process.killed) {
            stream.process.kill('SIGTERM')

            setTimeout(() => {
                try {
                    stream.process?.kill('SIGKILL')
                } catch {}
            }, 3000)
        }
    } catch {}

    stream.process?.on('close', () => {
        if (stream._cleaned) return
        stream._cleaned = true

        console.log('[FFMPEG CLOSED -> CLEAN HLS]', cameraId)

        const dir = config.HLS_DIR

        try {
            fs.readdirSync(dir).forEach(file => {
                if (file.startsWith(cameraId)) {
                    fs.unlinkSync(path.join(dir, file))
                }
            })
        } catch (e) {
            console.log('[CLEAN ERROR]', e.message)
        }

        delete streams[cameraId]
    })
}

wss.on('connection', (ws) => {
    console.log('client connected')

    ws.streams = new Set()

    ws.on('message', async (msg) => {
        let data

        try {
            data = JSON.parse(msg.toString())
        } catch {
            return
        }


        if (data.type === 'JOIN') {
            ws.raffleUuid = data.raffleUuid

            console.log('[JOIN]', ws.raffleUuid)

            ws.send(JSON.stringify({
                type: 'JOINED',
                raffleUuid: ws.raffleUuid
            }))

            return
        }

        if (data.type === 'LEAVE') {
            delete ws.raffleUuid
            return
        }



        const cameraUuid = data.camera_uuid
        if (!cameraUuid) return


        await lock.acquire(cameraUuid, async () => {
            if (data.type === 'REQUEST_CAMERA') {

                let stream = streams[cameraUuid]

                if (stream) {
                    stream.viewers.add(ws)
                    ws.streams.add(cameraUuid)

                    ws.send(JSON.stringify({
                        type: 'STREAM_READY',
                        url: stream.url
                    }))
                    return
                }

                let camera
                try {
                    console.log(`${config.API_BASE}/cameras/start/stream`)
                    const res = await fetch(
                        `${config.API_BASE}/cameras/start/stream`,
                        {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ uuid: cameraUuid }),
                        }
                    )

                    camera = await res.json()
                } catch (e) {
                    console.log('[API ERROR]', e)
                    return
                }

                const inputUrl = camera?.data?.url || camera?.url
                if (!inputUrl) return

                const outputPath = path.join(
                    config.HLS_DIR,
                    `${cameraUuid}.m3u8`
                )

                const ffmpegPath = config.FFMPEG_PATH


                const ffmpeg = spawn(ffmpegPath, [
                    // '-re',
                    // '-rtsp_transport', 'tcp',
                    // '-i', inputUrl,
                    //
                    // '-r', '24',
                    // '-c:v', 'libx264',
                    // '-preset', 'ultrafast',
                    //
                    // '-f', 'hls',
                    // '-hls_time', '2',
                    // '-hls_list_size', '3',
                    // '-hls_flags', 'delete_segments+append_list+independent_segments',

                    '-rtsp_transport', 'tcp',
                    '-i', inputUrl,
                    '-r', '24',
                    '-c:v', 'libx264',
                    '-preset', 'ultrafast',
                    '-tune', 'zerolatency',
                    '-g', '48',
                    '-keyint_min', '48',
                    '-f', 'hls',
                    '-hls_time', '1',
                    '-hls_list_size', '3',
                    '-hls_flags',
                    'delete_segments+append_list+independent_segments',

                    outputPath
                ])

                ffmpeg.stderr.on('data', d => {
                    console.log(`[FFMPEG ${cameraUuid}]`, d.toString())
                })

                streams[cameraUuid] = {
                    process: ffmpeg,
                    url: `${config.API_BASE}/cameras/hls/${cameraUuid}.m3u8`,
                    viewers: new Set()
                }

                stream = streams[cameraUuid]

                stream.viewers.add(ws)
                ws.streams.add(cameraUuid)


                ffmpeg.on('error', (err) => {
                    console.log('[FFMPEG ERROR]', err.message)
                    stopStream(cameraUuid)
                })

                ffmpeg.on('close', () => {
                    console.log('[FFMPEG CLOSED]', cameraUuid)
                    stopStream(cameraUuid)
                })

                try {
                    await waitForHls(outputPath)

                    ws.send(JSON.stringify({
                        type: 'STREAM_READY',
                        url: stream.url
                    }))
                } catch (e) {
                    console.log('[HLS NOT READY]', e.message)
                    stopStream(cameraUuid)
                }
            }
            if (data.type === 'LEAVE_CAMERA') {

                const stream = streams[cameraUuid]
                if (!stream) return

                stream.viewers.delete(ws)
                ws.streams.delete(cameraUuid)

                console.log('[LEAVE]', cameraUuid, 'viewers:', stream.viewers.size)

                if (stream.viewers.size === 0) {
                    stopStream(cameraUuid)
                }
            }
        })

    })


    ws.on('close', () => {

        for (const cameraUuid of ws.streams) {
            const stream = streams[cameraUuid]
            if (!stream) continue

            stream.viewers.delete(ws)

            console.log('[DISCONNECT]', cameraUuid, 'viewers:', stream.viewers.size)

            if (stream.viewers.size === 0) {
                stopStream(cameraUuid)
            }
        }
    })

    ws.send(JSON.stringify({ type: 'CONNECTED' }))
})

console.log('WebSocket running')





// ----------------------------------------------------------- Event


app.post('/event', (req, res) => {
    const { raffleUuId, type, payload } = req.body

    console.log('[EVENT]', raffleUuId)
    console.log('[CLIENTS]', wss.clients.size)

    wss.clients.forEach((client) => {
        console.log(
            'client raffle:',
            client.raffleUuid,
            'target:',
            raffleUuId,
            'state:',
            client.readyState
        )

        if (
            client.readyState === WebSocket.OPEN &&
            client.raffleUuid === raffleUuId
        ) {
            console.log('[SEND EVENT]')
            client.send(JSON.stringify({ type, payload }))
        }
    })
    res.json({ ok: true })
})

const authenticateBridge = (req, res, next) => {
    const expected = config.WHATSAPP_BRIDGE_TOKEN
    const received = req.get('authorization')?.replace(/^Bearer\s+/i, '')

    if (!expected || received !== expected) {
        return res.status(401).json({ status: 'unauthorized' })
    }

    next()
}

app.get('/whatsapp/status', authenticateBridge, (req, res) => {
    res.json(whatsapp.snapshot())
})

app.post('/whatsapp/connect', authenticateBridge, async (req, res) => {
    try {
        res.json(await whatsapp.connect())
    } catch (error) {
        console.error('[WHATSAPP CONNECT ERROR]', error)
        res.status(500).json({ status: 'error', message: 'WhatsApp connection failed' })
    }
})

app.post('/whatsapp/disconnect', authenticateBridge, async (req, res) => {
    try {
        res.json(await whatsapp.disconnect())
    } catch (error) {
        console.error('[WHATSAPP DISCONNECT ERROR]', error)
        res.status(500).json({ status: 'error', message: 'WhatsApp disconnect failed' })
    }
})

app.post(
    '/whatsapp/send',
    authenticateBridge,
    express.raw({ type: ['image/*', 'video/*'], limit: '52mb' }),
    async (req, res) => {
    try {
        const input = Buffer.isBuffer(req.body) ? req.query : req.body
        const {
            number,
            message,
            media_type: mediaType,
            media_mime: mediaMime,
            media_name: mediaName,
        } = input

        const result = await whatsapp.sendMessage(
            number,
            message,
            mediaType,
            Buffer.isBuffer(req.body) ? req.body : null,
            mediaMime,
            mediaName
        )

        res.json(result)
    } catch (error) {
        console.error('[WHATSAPP SEND ERROR]', error)

        res.status(422).json({
            status: 'error',
            message: error.message,
        })
    }
    }
)

app.use((error, req, res, next) => {
    if (error?.type === 'entity.too.large') {
        return res.status(413).json({
            status: 'error',
            message: 'حجم فایل بیشتر از ۵۰ مگابایت است.',
        })
    }

    next(error)
})

app.listen(config.LISTEN_PORT ?? 62162, () => {
    console.log('HTTP bridge running on 62162')
    console.log('WS running on 62111')
})

whatsapp.connect().catch(error => console.error('[WHATSAPP START ERROR]', error))
