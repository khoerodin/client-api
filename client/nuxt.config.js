require('dotenv').config()

const polyfills = [
  'Promise',
  'Object.assign',
  'Object.values',
  'Array.prototype.find',
  'Array.prototype.findIndex',
  'Array.prototype.includes',
  'String.prototype.includes',
  'String.prototype.startsWith',
  'String.prototype.endsWith'
]

module.exports = {
  mode: 'universal',

  /*
  ** Headers of the page
  */
  head: {
    title: process.env.APP_NAME,
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: process.env.APP_DESCRIPTION }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ],
    script: [
      { src: `https://cdn.polyfill.io/v2/polyfill.min.js?features=${polyfills.join(',')}` }
    ]
  },

  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#007bff' },

  router: {
    middleware: ['check-auth']
  },

  /*
  ** Global CSS
  */
  css: [
    { src: '~assets/sass/app.scss', lang: 'scss' }
  ],

  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    '~components/global',
    '~plugins/axios',
    '~plugins/vform',
    '~plugins/fontawesome',
    { src: '~plugins/bootstrap', ssr: false }
  ],

  /*
  ** Nuxt.js modules
  */
  modules: [
    '@nuxtjs/router'
  ],

  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extend(config, ctx) {
      // Run ESLint on save
      if (ctx.isDev && ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  },

  build: {
    extractCSS: true
  },

  env: {
    appName: process.env.APP_NAME,
    apiUrl: process.env.API_URL
  }
}
