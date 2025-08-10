<script setup>
import { ref } from 'vue';
import img1 from '@/assets/img/util/group.webp'
import img2 from '@/assets/img/util/cleanPerson.webp'
import img3 from '@/assets/img/util/financial.webp'
import bg from '@/assets/img/util/bg3.webp'

const step = ref(0)
const img = [ img1, img2, img3 ]
const title = [ 
  'Conectar con todos los miembros del condominio nunca fue tan facil', 
  'Obtén todos los servicios con un solo click', 
  'Mantente siempre informado'
]
const text = [ 
  'Hacemos que la conexion de todas las personas del condominio sea mas facil, fluida y acertada', 
  'Desde limpieza, mantenimiento de equipos todo facil de solicitar, con esta app', 
  'Recibe notificaciones en tiempo real de todas las novedades y eventos en la comunidad', 
]

</script>

<template>
  <div style="height: 100%; " class="w-full mx-auto tutorialSection" :style=" {backgroundImage:'url('+bg+ ')'}">
    <div class="position-relative relative  top__section">
      <div style="right: 1rem; top: 1rem;" 
        class="position-absolute absolute text-subtitle1 text-bold cursor-pointer text-gray-400 skip__button">
        Omitir
      </div>
        <Transition name="horizontal">
          <div class="flex flex-center h-full column" v-if="step==0">
            <img :src="img[step]" alt="" style="" class="pt-12 w-5/6 md:w-1/4">
            <div class="hiddenx md:block text-center">
              <div class="text-h5 text-bold text-gray-600">{{ title[step] }}</div>
              <div class="text-subtitle1 mt-2" style="font-weight: 500;">{{ text[step] }}</div>
            </div>
          </div>
        </Transition>
        <Transition name="horizontal">
          <div class="flex flex-center h-full column" v-if="step==1">
            <img :src="img[step]" alt="" style="" class="pt-12 w-5/6 md:w-1/4">
            <div class="hiddenx md:block text-center">
              <div class="text-h5 text-bold text-gray-600">{{ title[step] }}</div>
              <div class="text-subtitle1 mt-2" style="font-weight: 500;">{{ text[step] }}</div>
            </div>
          </div>
        </Transition>
        <Transition name="horizontal">
          <div class="flex flex-center h-full column" v-if="step==2">
            <img :src="img[step]" alt="" style="" class="pt-12 w-5/6 md:w-1/4">
            <div class="hiddenx md:block text-center">
              <div class="text-h5 text-bold text-gray-600">{{ title[step] }}</div>
              <div class="text-subtitle1 mt-2" style="font-weight: 500;">{{ text[step] }}</div>
            </div>
          </div>
        </Transition>


    </div>
    <div  class=" relative bottom__section  " style="">
      <div class="w-full bg-sky-600 h-full  bottom__section--container md:px-2 px-16 flex flex-center">
        <q-btn label="Siguiente" color="white" text-color="black" @click="step++" />
      </div>
    </div>
  </div>
</template>
<style lang="scss"> 
.tutorialSection{
  background-size: 100% 90%!important;
  background-repeat: no-repeat!important;
  background-color: white;
}
.top__section{
  height: 90%;
  z-index: 1; 
  background: #ffffffdb;
}
.bottom__section{
  height: 10%;
  z-index: 2; 
  background: #ffffffdb;

  &--container{
    border-top-left-radius: 2.3rem; 
    border-top-right-radius: 2.3rem; 
    box-shadow: 0px -0.2rem 1rem 0px rgb(0 0 0 / 38%)
  }
}

@media screen and (max-width: 780px){
.tutorialSection{
  background-size: 100% 58%!important;
  background-repeat: no-repeat!important;
  background-color: white;
}
.top__section{
  height: 55%;
  z-index: 1; 
  background: #ffffffdb;
}
.bottom__section{
  height: 45%;
  z-index: 2; 
  background: #ffffffdb;

  &--container{
    border-top-left-radius: 2.3rem; 
    border-top-right-radius: 2.3rem; 
    box-shadow: 0px -0.2rem 1rem 0px rgb(0 0 0 / 38%)
  }
}
}
</style>
