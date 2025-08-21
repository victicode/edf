<script setup>
  import { storeToRefs } from 'pinia';
  import { useAuthStore } from '@/services/store/auth.services';
  import bg from '@/assets/img/util/bg3.webp'
  import wozIcons from '@/assets/icons/index'
import { useRouter } from 'vue-router';
  // const wozIcons= wozIcons
  const { user } = storeToRefs(useAuthStore())
  const router = useRouter()
  const menu = [
    {
      title:'Usuarios',
      icon: wozIcons.user,
      link:'/users',
    },
    {
      title:'Servicios',
      icon: wozIcons.services,
      link:'/services',
    },
    {
      title:'Reservas',
      icon: wozIcons.reserve,
      link:'/reserves',
    },
    {
      title:'Areas comunes',
      icon: wozIcons.atraction,
      link:'/comun-area',
    },
    {
      title:'Balance de cuentas',
      icon: wozIcons.payHouse,
      link:'/balances',
    },
    {
      title:'Noticias',
      icon: wozIcons.news,
      link:'/news',
    },
    {
      title:'Ajustes',
      icon: wozIcons.config,
      link:'/config',
    }
  ];

  const goTo = (url) => {
    router.push(url)
  }
</script>
<template>
  <div class="h-full w-full px-2">
    <div class="row md:pt-10 pt-5  md:px-16">
      <div class="col-md-2 md:px-8 col-6 px-4 my-3" v-for="(items, key) in menu" :key="key" @click="goTo(items.link)">
        <div class="boxItem" :style=" {backgroundImage:'url('+bg+ ')'}" > 
          <div class="h-full w-full flex column justify-center" style="background: rgb(242 242 242 / 92%);">
            <div class="text-primary text-center text-subtitle1 px-2 text-bold ellipsis" style="width: 100%;">
              {{ items.title }}
            </div>
            <div v-html="items.icon" class="flex flex-center mt-2"/>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<style lang="scss" scoped>
.boxItem{
  border-radius: 1rem;
  overflow: hidden;
  border: 2px solid rgb(3, 156, 195) ;
  height: 9rem ;
  width: 100%;
  box-shadow: 0px 0.1rem 0.5rem 0px rgba(0, 0, 0, 0.177);
  background-repeat: no-repeat;
  background-size: cover;
  transition: all 0.7s ease-in-out;
  cursor: pointer;
  &:hover{
    transform: scale(1.03);
  }
}
@media (max-width: 780px) {
  .boxItem{
    height: 7.5rem ;
  }
}

</style>