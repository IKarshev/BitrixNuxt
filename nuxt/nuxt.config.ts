// nuxt.config.ts
export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  css: [
    '~/assets/css/reset.css',
    '~/assets/scss/main.scss',
  ],
  app: {
    pageTransition: { 
      name: 'fade', 
      mode: 'out-in' 
    },
    layoutTransition: {
      name: 'layout',
      mode: 'out-in'
    }
  },
})