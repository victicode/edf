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
    title: 'Mis pagos',
    icon: iconsApp.payApartment,
    link: '/client/pays/list',
  },
  {
    title: 'Mi unidad',
    icon: iconsApp.myUnit,
    link: '/client/department/my-unit',
  },
  {
    title: 'Estado',
    icon: iconsApp.contract,
    link: '/client/balance/list',
  },


];

const goTo = (url) => {
  router.push(url)
}
</script>
<template>

  <div class="h-full w-full px-2">
    <div class="row md:pt-10 pt-5  md:px-20">
      <div class="col-md-3 md:px-20 col-6 px-7 my-3" v-for="(items, key) in menu" :key="key" @click="goTo(items.link)">
        <div class="px-3">
          <div class="boxItem ">
            <div class="flex justify-center items-center h-full w-full p-1">
              <!-- <img :src="items.icon" class="w-full md:w-auto h-full" /> -->
              <div v-html="items.icon" class="flex justify-center mt-0" />
            </div>
          </div>
        </div>
        <div class="text-center mt-2  text-title-squad">
          {{ items.title }}
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped></style>