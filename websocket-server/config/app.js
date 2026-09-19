require('dotenv').config()

module.exports = {
    NODE_ENV: process.env.NODE_ENV,

    PORT: process.env.PORT,
    LISTEN_PORT: process.env.LISTEN_PORT,

    API_BASE: process.env.API_BASE,

    HLS_DIR: process.env.HLS_DIR,

    FFMPEG_PATH: process.env.FFMPEG_PATH,

    WHATSAPP_BRIDGE_TOKEN: process.env.WHATSAPP_BRIDGE_TOKEN,
    WHATSAPP_WEBHOOK_URL: process.env.WHATSAPP_WEBHOOK_URL,
    WHATSAPP_AUTH_DIR: process.env.WHATSAPP_AUTH_DIR,
    WHATSAPP_PROXY_URL: process.env.WHATSAPP_PROXY_URL || 'http://192.168.200.2:10809',

    IS_DEVELOPMENT: process.env.NODE_ENV === 'development',
}
