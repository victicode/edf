<script setup>
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/services/store/auth.services';
import bg from '@/assets/img/util/bg3.webp'
import iconsApp from '@/assets/icons/index'
import { useRouter } from 'vue-router';
import anuncios from '@/assets/img/menu/anuncios.svg'
import atencion from '@/assets/img/menu/atencion.svg'
import mi_departamento from '@/assets/img/menu/mi_departamento.svg'
import mis_reservas from '@/assets/img/menu/mis_reservas.svg'
import pagos from '@/assets/img/menu/pagos.svg'

const { user } = storeToRefs(useAuthStore())
const router = useRouter()
const menu = [
  // {
  //   title: 'Mi Perfil',
  //   icon: iconsApp.users2,
  //   subtitle: 'Configura tu perfil',
  //   link: '/client/profile',
  // },
  {
    title: 'Apartamento',
    icon: iconsApp.departmet,
    subtitle: 'Informacion sobre tu inmobiliario',
    link: '/client/department/options',
  },
  {
    title: 'Reservas',
    icon: iconsApp.reserve,
    subtitle: 'Gestiona tu reservas',
    link: '/client/reserves/list',
  },
  {
    title: 'Anuncios',
    icon: iconsApp.news2,
    subtitle: 'Observa y crea anuncios',
    link: '/client/notices/list',
  },
  {
    title: 'Eventos',
    icon: iconsApp.events,
    subtitle: 'Consulta los eventos programados',
    link: '/client/events',
  },
  {
    title: 'Atención',
    icon: iconsApp.helpdesk,
    subtitle: 'Consulta los eventos programdos',
    link: '/client/services/list',
  },


];

const goTo = (url) => {
  router.push(url)
}
</script>
<template>
  <div class="h-full w-full px-2">
    <div class="row md:pt-10 pt-5  md:px-20">
      <div class="col-md-3 md:px-8 col-6 px-3 my-3" v-for="(items, key) in menu" :key="key" @click="goTo(items.link)">
        <!-- <div class="boxItem" :style="{ backgroundImage: 'url(' + bg + ')' }"> -->
        <div class="boxItem ">
          <!-- <div class="h-full w-full flex column justify-center" style="background: rgb(242 242 242 / 92%);"> -->
          <div class="h-full w-full flex column justify-between py-2  md:pl-2 pl-1 pr-2">
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

<style lang="scss" scoped></style>