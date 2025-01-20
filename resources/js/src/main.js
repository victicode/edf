import App from '@/App.vue'
import { Quasar } from 'quasar';
import { createApp } from 'vue';
import quasarIconSet from 'quasar/icon-set/eva-icons'
import { createPinia } from 'pinia'
import router  from '@/routes'
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/ionicons-v4/ionicons-v4.css'
import '@quasar/extras/eva-icons/eva-icons.css'

import 'quasar/src/css/index.sass'

const pinia = createPinia()

const myApp = createApp(App)

myApp.use(Quasar, {
  plugins: {}, // import Quasar plugins and add here
  iconSet: quasarIconSet,
})

myApp.use(pinia)
myApp.use(router)

myApp.mount('#app')