import { createWebHistory, createRouter } from 'vue-router'

import HomeView from '@/view/homeView.vue'
import authLayout from '@/layouts/authLayout.vue'
import panelLayout from '@/layouts/panelLayout.vue'

import auth from './middlewares/auth'
import guest from './middlewares/guest'


const routes = [
  { 
    path: '/', 
    component: authLayout,
    redirect: '/login',
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
  { 
    path: '/', 
    component: panelLayout,
    beforeEnter: auth,
    children: [
      {
        path: '/dashboard', 
        component: HomeView, 
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido'
        }
      }
    ]
  },

  
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router