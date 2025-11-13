<script setup>
import logo from '@/assets/img/logo/logo.webp'


</script>
<template>
  <div class="w-full h-full bg-sky-600 flex flex-center overFlow" >
    <div class="bg-white logo__contanier flex flex-center">
      <img :src="logo" alt="" style="  width: 5rem; transform: translateX(3px);">
    </div>
  </div>
</template>

<style lang="scss">
.overFlow{
  position: absolute;
  top:0;
  z-index: 3;
}
.logo__contanier{
  width: 8rem;
  height: 8rem;
  border-radius: 100%;
  animation: pulseIt 0.8s alternate-reverse infinite;
}
@keyframes pulseIt {
  0%{
    transform: scale(0.9);
    opacity: 0.1;
    box-shadow: 0px 0px 0px 20px rgba(255, 255, 255, 0.039);
  }
  100%{
    transform: scale(1.1);
    opacity: 1;
    box-shadow: 0px 0px 0px 10px white;


  }
}
</style>