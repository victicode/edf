import { createWebHistory, createRouter } from 'vue-router'

import HomeView from '@/view/dashboard.vue'
import authLayout from '@/layouts/authLayout.vue'
import auth from './middlewares/auth'
import guest from './middlewares/guest'


const routes = [
  { 
    path: '/dashboard', 
    component: HomeView, 
    beforeEnter: auth,
    meta:{
      title: 'Bienvenido'
    }
  },

  { 
    path: '/', 
    component: authLayout,
    beforeEnter: guest,
    children: [
      {
        path:'/login',
        component: () => import('@/view/auth/login.vue'),
        meta:{
          title: 'Bienvenido'
        }
      },
      {
        path:'/register',
        component: () => import('@/view/auth/login.vue'),
        meta:{
          title: 'Bienvenido'
        }
      },
    ]
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router