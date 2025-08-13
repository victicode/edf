<script setup>
  import { storeToRefs } from 'pinia';
  import { useAuthStore } from '@/services/store/auth.services';
  import bg from '@/assets/img/util/bg3.webp'
  import wozIcons from '@/assets/icons/index'
  // const wozIcons= wozIcons
  const { user } = storeToRefs(useAuthStore())
</script>
<template>
  <div class="h-full w-full px-2">
    <div class="row pt-5  md:px-16">
      <div class="col-md-2 md:px-8 col-6 px-4 my-3">
        <div class="boxItem" :style=" {backgroundImage:'url('+bg+ ')'}"> 
          <div class="h-full w-full flex column justify-center" style="background: rgb(242 242 242 / 92%);">
            <div class="text-primary text-center text-subtitle1 text-bold">
              Condominio
            </div>
            <div v-html="wozIcons.departmet" class="flex flex-center mt-2"/>
          </div>
        </div>
      </div>
      <div class="col-md-2 md:px-8 col-6 px-4 my-3">
        <div class="boxItem" :style=" {backgroundImage:'url('+bg+ ')'}"> 
          <div class="h-full w-full flex column justify-center" style="background: rgb(242 242 242 / 92%);">
            <div class="text-primary text-center text-subtitle1 text-bold">
              Usuario
            </div>
            <div v-html="wozIcons.user" class="flex flex-center mt-2"/>
          </div>
        </div>
      </div>
      <div class="col-md-2 md:px-8 col-6 px-4 my-3">
        <div class="boxItem" :style=" {backgroundImage:'url('+bg+ ')'}"> 
          <div class="h-full w-full flex column justify-center" style="background: rgb(242 242 242 / 92%);">
            <div class="text-primary text-center text-subtitle1 text-bold">
              Administración 
            </div>
            <div v-html="wozIcons.admin" class="flex flex-center mt-2"/>
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
    height: 9.5rem ;
  }
}

</style>