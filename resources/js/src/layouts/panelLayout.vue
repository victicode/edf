<script setup>
import headerLayout from '@/components/layout/headerLayout.vue';
import infoNewSideBar from '@/components/layout/infoNewSideBar.vue';
import navbarAdmin from '@/components/layout/navbarAdmin.vue';
import { useRoute } from 'vue-router';
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/services/store/auth.services';
import loaderPage from '@/components/layout/loaderPage.vue';
import { onMounted, ref } from 'vue';
import logoutModal from '@/components/layout/logoutModal.vue';
import storage from '@/services/storage'

  const route = useRoute()
  const ready = ref(false)
  const { user } = storeToRefs(useAuthStore())
  const showModal = ref('')

  onMounted(() => {
    useAuthStore().currentUser()
    .then((response) => {
      if(user.value.rol_id){
        ready.value = true
      }
    })
    .catch(() => {
      console.log('ups')
      storage.deleteItem("access_token");
    })

  })

</script>

<template>
  <div class="h-full bg-stone-100 w-full" style="position: relative; overflow: hidden;">
    <template v-if="ready">
      <headerLayout class="header__container" />
      <section class="page__container">
        <router-view v-slot="{ Component }">
          <transition name="horizontal">
            <component :is="Component" />
          </transition>
        </router-view>
      </section>
      <navbarAdmin v-if="['dashboardAdmin', 'financePage', 'usersAdmin' ].includes(route.name) " @logoutModal="showModal='logout'" />
      <infoNewSideBar />

      <logoutModal :dialog="(showModal == 'logout')" @closeModal="showModal = ''"/>
    </template>
    <loaderPage v-else />
  </div>
</template>

<style lang="scss">
.header__container{
  height: 12%;
  overflow: hidden;
}
.page__container{
  height: 78%;
  overflow-x: hidden;
  overflow-y: auto;
}
</style>
