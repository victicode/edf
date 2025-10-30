<script setup>
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/services/store/auth.services';
import { inject, ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useNotificationsStore } from '@/services/store/notifications.store'
const route = useRoute()
const router = useRouter()
const { user } = storeToRefs(useAuthStore())
const notificationsStore = useNotificationsStore()
const emitter = inject('emitter')
const materialIcons = inject('materialIcons')
const pagTitle = ref(route.meta.pagTitle)

const showSidebar = () => {
  emitter.emit('showInfoNews')
}

const changePagTitle = (title) => {
  pagTitle.value = title
}
watch(route, (newValue) => {
  pagTitle.value = newValue.meta.pagTitle
});


onMounted(() => {
  emitter.on('pagTitle', changePagTitle)
})
</script>

<template>
  <section class="md:px-8 md:mx-28 pt-2 px-3 flex justify-between items-center bg-primary header__container"
    style=" border-bottom-left-radius: 2rem; border-bottom-right-radius: 2rem;">
    <template v-if="['dashboardAdmin', 'financePage', 'usersAdmin'].includes(route.name)">
      <div class="flex items-center">
        <div class="userAvatar flex flex-center">
          {{ user.name.charAt(0) }}
        </div>
        <div class="ml-3">
          <div class="text-white" style="font-size: 1rem;">
            Hola {{ user.name }}
          </div>
          <div class="text-gray-100 " style="font-size: 0.85rem;">
            {{ user.rol_id == 1 ? 'Admin' : 'P-201' }}
          </div>
        </div>
      </div>
      <div class="relative">
        <q-badge class="badgeNotificationCount" 
        v-if="notificationsStore.unreadCount > 0" color="red"  :label="notificationsStore.unreadCount" />
        <q-btn id="notiftyButton" :icon="materialIcons.roundNotifications" unelevated color="white" flat size="1rem" round
          @click="router.push({ name: 'notificationsPage' })" />
      </div>
    </template>
    <template v-else>
      <div class="flex items-center">
        <div class="flex items-center">
          <q-btn :icon="materialIcons.outlinedArrowBack" unelevated color="white" flat size="1rem" round
            @click="router.go(-1)" />
        </div>
        <div class="text-h6 text-bold text-white ml-2">
          {{ pagTitle }}
        </div>
      </div>
    </template>
  </section>
</template>

<style lang="scss">
.badgeNotificationCount{
  top: 0.5rem;
  right: 0.5rem;
  position: absolute;
  z-index: 2;
}
.header__container {
  box-shadow: 0px -0.1rem 1rem 0px rgb(0 0 0 / 38%);
}

.userAvatar {
  width: 2.7rem;
  height: 2.7rem;
  font-size: 1rem;
  font-weight: 700;
  border: 3px solid white;
  background: rgb(0, 104, 115);
  color: white;
  border-radius: 50%;
}
</style>