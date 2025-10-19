<script setup>
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/services/store/auth.services';
import bg from '@/assets/img/util/bg3.webp'
import iconsApp from '@/assets/icons/index'
import { useRouter } from 'vue-router';

const { user } = storeToRefs(useAuthStore())
const router = useRouter()
const menu = [

  {
    title: 'Areas comunes',
    icon: iconsApp.atraction,
    subtitle: 'Gestiona las areas comunes',
    link: '/admin/comun-area/list',
  },
  {
    title: 'Noticias',
    icon: iconsApp.news,
    subtitle: 'Envia información sobre: eventos, servicio, etc',
    link: '/news',
  },
  {
    title: 'Ajustes',
    icon: iconsApp.config,
    subtitle: 'Configura la app',
    link: '/config',
  },

];

const goTo = (url) => {
  router.push(url)
}
</script>
<template>
  <div class="h-full w-full px-2">
    <div class="row md:pt-10 pt-5  md:px-20">
      <div class="col-md-3 md:px-8 col-6 px-2 my-3" v-for="(items, key) in menu" :key="key" @click="goTo(items.link)">
        <!-- <div class="boxItem" :style="{ backgroundImage: 'url(' + bg + ')' }"> -->
        <div class="boxItem ">
          <!-- <div class="h-full w-full flex column justify-center" style="background: rgb(242 242 242 / 92%);"> -->
          <div class="h-full w-full flex column justify-between py-2 md:pl-2 pl-1 pr-3">
            <div class="text-primary text-start px-2 text-bold ellipsis boxTitle" style="width: 100%;">
              {{ items.title }}
              <div class="text-stone-400 boxText md:mt-1">
                {{ items.subtitle }}
              </div>
            </div>
            <div v-html="items.icon" class="flex justify-end mt-2 md:mt-0" />
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<style lang="scss"></style>