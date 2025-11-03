<script setup>
import headerLayout from '@/components/layout/headerLayout.vue';
import infoNewSideBar from '@/components/layout/infoNewSideBar.vue';
import navbarAdmin from '@/components/layout/navbarAdmin.vue';
import { useRoute } from 'vue-router';
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/services/store/auth.services';
import loaderPage from '@/components/layout/loaderPage.vue';
import { onMounted, ref, watch } from 'vue';
import logoutModal from '@/components/layout/logoutModal.vue';
import storage from '@/services/storage'
import { useNotificationsStore } from '@/services/store/notifications.store'
import { useQuasar } from 'quasar'

const route = useRoute()
const ready = ref(false)
const { user } = storeToRefs(useAuthStore())
const showModal = ref('')
const notificationsStore = useNotificationsStore()
const $q = useQuasar()
const prevUnread = ref(0)
const lastShownId = ref(null)

onMounted(() => {
  useAuthStore().currentUser()
    .then((response) => {
      if (user.value.rol_id) {
        ready.value = true
        getNotifications()
      }
    })
    .catch(() => {
      console.log('ups')
      storage.deleteItem("access_token");
    })

})

const getNotifications = () => {
  // Inicializar notificaciones
  notificationsStore.fetchUnreadCount().finally(() => {
    prevUnread.value = notificationsStore.unreadCount
  })
  notificationsStore.bindEchoListener(user.value.id)

}
watch(() => notificationsStore.unreadCount, (newVal, oldVal) => {
  prevUnread.value = newVal
})

watch(() => notificationsStore.lastIncoming, (notif) => {

  console.log(notif)
  if (!notif) return
  // Evitar duplicados
  const id = notif.id || `${notif.title}-${notif.message}-${notif.url}-${Date.now()}`
  if (lastShownId.value === id) return
  lastShownId.value = id

  // Si es cliente y es una notificación de "Reserva creada", NO mostrar toast
  const isClient = user.value?.rol_id && user.value.rol_id != 1
  const title = notif.title || notif?.data?.title
  const message = notif.message || notif?.data?.message || 'Nueva notificación recibida'

  if (isClient && title === 'Reserva creada') {
    return
  }

  $q.notify({
    classes:'q-mt-lg', 
    color: 'primary', 
    message: `${title ? title + '' : ''}`, 
    icon: 'eva-bell-outline', 
    position: 'top-right' 
  })
})

</script>

<template>
  <div class="h-full bg-stone-100 w-full" style="position: relative; overflow: hidden;">
    <template v-if="ready">
      <headerLayout class="header__container" v-if="!(['reserveConfirm', 'reservePay', 'reservePayConfirm'].includes(route.name))" />
      <section
        :class="{ 'withoutNav': ['reserveConfirm', 'reservePay', 'reservePayConfirm'].includes(route.name), 'page__container': ['dashboardAdmin', 'financePage', 'usersAdmin'].includes(route.name), 'page_continerFull': !(['dashboardAdmin', 'financePage', 'usersAdmin'].includes(route.name)) }">
        <router-view v-slot="{ Component }">
          <transition name="horizontal">
            <component :is="Component" />
          </transition>
        </router-view>
      </section>
      <navbarAdmin v-if="['dashboardAdmin', 'financePage', 'usersAdmin'].includes(route.name)"
        @logoutModal="showModal = 'logout'" />
      <infoNewSideBar />

      <logoutModal :dialog="(showModal == 'logout')" @closeModal="showModal = ''" />
    </template>
    <loaderPage v-else />
  </div>
</template>

<style lang="scss">

.header__container {
  height: 12%;
  overflow: hidden;
}

.page__container {
  height: 78%;
  overflow: hidden;
  // overflow-x: hidden;
  // overflow-y: auto;
}

.page_continerFull {
  height: 88%;
  overflow: hidden;
  // overflow-x: hidden;
  // overflow-y: auto;
}

.withoutNav {
  height: 100%;
  overflow: hidden;
}
</style>
