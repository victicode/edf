import App from '@/App.vue'
import { createApp } from 'vue';
import quasarIconSet from 'quasar/icon-set/eva-icons'
import { createPinia } from 'pinia'
import {
  Quasar,
  Notify,
  AddressbarColor
} from 'quasar'
import router  from '@/routes'
// import '@quasar/extras/material-symbols-outlined/material-symbols-outlined.css'
import '@quasar/extras/material-icons-outlined/material-icons-outlined.css'
import { 
  outlinedArrowBack, 
  outlinedAddHomeWork,
  outlinedPaid,
  outlinedEvent,
  outlinedHomeWork,
} from '@quasar/extras/material-icons-outlined/index.js'

import { 
  roundNotifications,
} from '@quasar/extras/material-icons-round/index.js'

import '@quasar/extras/ionicons-v4/ionicons-v4.css'
import '@quasar/extras/eva-icons/eva-icons.css'
import mitt from 'mitt'
import 'quasar/src/css/index.sass'
import '@/assets/scss/app.scss'
// import { useAuthStore } from '@/services/store/auth.services';

const materialIcons = {
  outlinedArrowBack,
  outlinedAddHomeWork,
  outlinedPaid,
  outlinedEvent,
  outlinedHomeWork,
  roundNotifications,
}
const pinia = createPinia()

const myApp = createApp(App)
const emitter = mitt()
myApp.use(Quasar, {
  plugins: {
    Notify,
    AddressbarColor
  },
  iconSet: quasarIconSet,
})

myApp.use(pinia)
myApp.use(router)

myApp.provide('emitter', emitter)
myApp.provide('materialIcons', materialIcons)


myApp.mount('#app')

