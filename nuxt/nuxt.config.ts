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
      name: 'page', 
      mode: 'out-in'
    },
  },
  router: {
    options: {
      scrollBehaviorType: 'smooth'
    }
  }
})