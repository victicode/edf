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
        name:'dashboardAdmin',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Dashboard'
        }
      },
      {
        path: '/admin/users', 
        component: () => import('@/view/admin/usersPage.vue'),
        name:'usersAdmin',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Usuarios'
        }
      },
      {
        path: '/admin/finance', 
        component: () => import('@/view/admin/financePage.vue'),
        name:'financePage',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Finanzas'
        }
      },
      {
        path: '/services', 
        component: () => import('@/view/admin/servicesPage.vue'),
        name:'servicesAdmin',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Sevicios'
        }
      },
      {
        path: '/reserves', 
        component: () => import('@/view/admin/reservesPage.vue'),
        name:'reservedAdmin',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Reservas'
        }
      },
      {
        path: '/comun-area', 
        component: () => import('@/view/admin/comunAreasPage.vue'),
        name:'comunAreaAdmin',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Areas comunes'
        }
      },
      {
        path: '/balances', 
        component: () => import('@/view/admin/balancesPage.vue'),
        name:'balanceAdmin',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Banlances'
        }
      },
      {
        path: '/news', 
        component: () => import('@/view/admin/newsPage.vue'),
        name:'newsAdmin',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Noticias'
        }
      },
      {
        path: '/config', 
        component: () => import('@/view/admin/configPage.vue'),
        name:'Configuración',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Dashboard'
        }
      },
      {
        path: '/admin/users/list', 
        component: () => import('@/view/admin/users/usersList.vue'),
        name:'usersList',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Usuarios'
        }
      },
      {
        path: '/admin/users/form/add', 
        component: () => import('@/view/admin/users/createUser.vue'),
        name:'usersAdd',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Crear Usuario'
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