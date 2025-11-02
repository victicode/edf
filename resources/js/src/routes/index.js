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
        path: '/admin/department/list', 
        component: () => import('@/view/admin/Department/departmentList.vue'),
        name:'departmentList',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Apartamentos'
        }
      },
      {
        path: '/admin/comun-area/list', 
        component: () => import('@/view/admin/ComunAreas/comunAreasList.vue'),
        name:'comunAreasList',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Areas comunes'
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
      {
        path: '/admin/users/assing-apartment/:id', 
        component: () => import('@/view/admin/users/assingApartment.vue'),
        name:'assingDepartment',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Asignar Apartamento'
        }
      },
      {
        path: '/admin/department/form/add', 
        component: () => import('@/view/admin/Department/createDepartment.vue'),
        name:'departmentAdd',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Agregar apartamento'
        }
      },
      {
        path: '/admin/comun-area/form/add', 
        component: () => import('@/view/admin/ComunAreas/createComunArea.vue'),
        name:'comunAreaAdd',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Agregar area común'
        }
      },
      {
        path: '/admin/comun-area/form/update/:id', 
        component: () => import('@/view/admin/ComunAreas/updateComunArea.vue'),
        name:'comunAreaUpdate',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Editar area común'
        }
      },
      {
        path: '/admin/comun-area/bookings/:id/list', 
        component: () => import('@/view/admin/ComunAreas/bookingsList.vue'),
        name:'comunAreaBookingsList',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Lista de reservaciones'
        }
      },
      {
        path: '/admin/pay/validate/:id', 
        component: () => import('@/view/admin/Pays/validatePay.vue'),
        name:'PayValidate',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Validar pago'
        }
      },
      

      // ---- client Routes -----

      {
        path: '/client/reserves/list', 
        component: () => import('@/view/client/Reserves/reserveList.vue'),
        name:'reserveClient',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Reservas'
        }
      },
      {
        path: '/client/reserves/form/add', 
        component: () => import('@/view/client/Reserves/createReserve.vue'),
        name:'reserveClientAdd',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Reservas'
        }
      },
      {
        path: '/client/reserves/confirm-reserve/:id', 
        component: () => import('@/view/client/Reserves/confirmReserve.vue'),
        name:'reserveConfirm',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Reservas realizada'
        }
      },
      {
        path: '/client/reserves/pay-reserve/:id', 
        component: () => import('@/view/client/Reserves/payReserve.vue'),
        name:'reservePay',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Realiza el pago'
        }
      },
      {
        path: '/client/reserves/pay/details/:id', 
        component: () => import('@/view/client/Reserves/payConfirmReserve.vue'),
        name:'reservePayConfirm',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Pago realizado!'
        }
      },
      {
        path: '/client/reserves/view/:id', 
        component: () => import('@/view/client/Reserves/viewReserve.vue'),
        name:'viewReserve',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Detalles de reserva'
        }
      }
      ,
      {
        path: '/client/notifications',
        component: () => import('@/view/client/Notifications/notificationsPage.vue'),
        name:'notificationsPage',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Notificaciones'
        }
      },
      {
        path: '/client/department/options',
        component: () => import('@/view/client/Apartments/optionList.vue'),
        name:'apartmentOption',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Gestion de apartamento'
        }
      },
      {
        path: '/client/department/my-unit',
        component: () => import('@/view/client/Apartments/myUnit.vue'),
        name:'apartmentClient',
        beforeEnter: auth,
        meta:{
          title: 'Bienvenido',
          pagTitle: 'Gestion de apartamento'
        }
      }
      
    ]
  },
  // Ruta 404 - debe estar al final para capturar todas las rutas no encontradas
  {
    path: '/:pathMatch(.*)*',
    component: () => import('@/view/errors/404.vue'),
    name: '404',
    meta: {
      title: 'Página no encontrada',
      pagTitle: '404'
    }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router