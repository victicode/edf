<script setup>
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/services/store/auth.services';
import { inject, ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useNotificationsStore } from '@/services/store/notifications.store'
import logo from '@/assets/img/logo/logo-white.webp'
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
  <section class="md:px-8 md:mx-28 py-4 px-4 flex justify-between items-start bg-primary header__container">
    <template v-if="['dashboardAdmin', 'financePage', 'usersAdmin'].includes(route.name)">
      <div>
          <div>
            <q-icon name="eva-menu-outline" color="white" size="1.5rem" />
          </div>
          <div class="text-white my-2">
            <div class="text-subtitle2" style="font-weight:400; ">¡Hola!</div>
            <div class="text-subtitle1" style="font-weight:600; text-transform: capitalize;">{{user.name}}</div>
          </div>
          <div class="text-white">
            <div class="text-subtitle2" style="font-weight:400; ">Mantenimiento Enero</div>
            <div>375.25</div>
          </div>
      </div>
      <div class="flex items-start">
        <img :src="logo" alt="" style="height:5rem" class="mt-8">
        <div class="relative">
          <q-badge class="badgeNotificationCount" 
          v-if="notificationsStore.unreadCount > 0" color="red"  :label="notificationsStore.unreadCount" />
          <q-icon :name="materialIcons.roundNotifications" color="white" size="1.8rem"
            @click="router.push({ name: 'notificationsPage' })" />
        </div>
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
  //box-shadow: 0px -0.1rem 1rem 0px rgb(0 0 0 / 38%);
  border-radius: 1rem;
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