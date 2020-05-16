export default {
  mode: 'universal',
  env: {
    apiURL: process.env.API_URL || 'http://127.12.1.1'
  },
  /*
  ** Headers of the page
  */
  head: {
    title: process.env.npm_package_name || '',
    meta: [
      {charset: 'utf-8'},
      {name: 'viewport', content: 'width=device-width, initial-scale=1'},
      {hid: 'description', name: 'description', content: process.env.npm_package_description || ''}
    ],
    link: [
      {rel: 'icon', type: 'image/x-icon', href: '/favicon.ico'}
    ]
  },
  /*
  ** Customize the progress-bar color
  */
  loading: {color: '#fff'},
  /*
  ** Global CSS
  */
  css: [
    '@/assets/scss/global.scss',
    '@/assets/scss/spacing.scss'
  ],
  /*
  ** Plugins to load before mounting the App
  */
  plugins: [],
  /*
  ** Nuxt.js dev-modules
  */
  buildModules: [
    '@nuxt/typescript-build'
  ],
  /*
  ** Nuxt.js modules
  */
  modules: [
    // Doc: https://buefy.github.io/#/documentation
    'nuxt-buefy',
    '@nuxtjs/style-resources',
    // Doc: https://axios.nuxtjs.org/usage
    '@nuxtjs/axios',
    // Doc: https://github.com/nuxt-community/dotenv-module
    '@nuxtjs/dotenv',
    // Doc: https://auth.nuxtjs.org/
    '@nuxtjs/auth',
    // Doc: https://github.com/nuxt-community/apollo-module
    '@nuxtjs/apollo',
  ],
  /*
  ** Axios module configuration
  ** See https://axios.nuxtjs.org/options
  */
  axios: {
    baseURL: 'http://heimdall.local:80',
    credentials: true
  },
  /*
  * Auth module configuration
  * see: https://auth.nuxtjs.org/
  */
  auth: {
    redirect: {
      login: '/login',
      logout: '/login',
      home: '/'
    },
    strategies: {
      local: {
        endpoints: {
          login: {url: '/login', method: 'post', propertyName: false},
          user: {url: '/api/user', method: 'get', propertyName: false},
          logout: {url: '/logout', method: 'post'}
        },
        tokenRequired: false,
        tokenType: false
      }
    },
    localStorage: false
  },
  /*
  ** Router config
  */
  router: {
    middleware: ['auth']
  },
  // Give apollo module options
  apollo: {
    tokenName: 'apollo-token',
    authenticationType: 'Basic', // default: 'Bearer'
    watchLoading: '~/plugins/apollo-watch-loading-handler.js',
    errorHandler: '~/plugins/apollo-error-handler.js',
    clientConfigs: {
      default: '~/plugins/apollo-config',
    }
  },
  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extend(config, ctx) {
    }
  }
}
