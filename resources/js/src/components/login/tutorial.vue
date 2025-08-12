<script setup>
import { ref } from 'vue';
import img1 from '@/assets/img/util/group.webp'
import img2 from '@/assets/img/util/cleanPerson.webp'
import img3 from '@/assets/img/util/financial.webp'
import bg from '@/assets/img/util/bg3.webp'
import storage from '@/services/storage'

const emit = defineEmits(['end'])
const step = ref(0)
const img = [ img1, img2, img3 ]
const title = [ 
  'Conectar con todos los miembros del condominio nunca fue tan facil', 
  'Reservaciones de areas comunes en pocos pasos', 
  'Mantente siempre informado'
]
const text = [ 
  'Hacemos que la conexion de todas las personas del condominio sea mas facil, fluida y acertada.', 
  'Desde nuestra app, puede resevar y pagar por el uso las areas comunes de forma rapida y sencillas.', 
  'Recibe notificaciones en tiempo real de todas las novedades y eventos en la comunidad.', 
]
const endTutorial = () => {
  emit('end')
  storage.setItem('tutorial', true)
}
const nextStep = () => {
  if(step.value == 2){
    endTutorial()
    return
  }
  step.value++
}
</script>

<template>
  <div style="height: 100%; " class="w-full mx-auto tutorialSection" :style=" {backgroundImage:'url('+bg+ ')'}">
    <div class="position-relative relative  top__section">
      <div style="right: 1rem; top: 1rem;" 
        class="position-absolute absolute text-subtitle1 text-bold cursor-pointer text-gray-400 skip__button px-4 py-1" @click="endTutorial()">
        Omitir
      </div>
      <Transition name="horizontal">
        <div class="flex flex-center h-full column" v-if="step==0">
          <img :src="img[step]" alt="" style="" class="pt-12 w-5/6 md:w-1/4">
          <div class="hiddenx md:block text-center pt-2">
            <div class="text-h4 text-bold text-gray-600">{{ title[step] }}</div>
            <div class="text-h6 mt-2" style="font-weight: 500;">{{ text[step] }}</div>
          </div>
        </div>
      </Transition>
      <Transition name="horizontal">
        <div class="flex flex-center h-full column" v-if="step==1">
          <img :src="img[step]" alt="" style="" class="pt-12 w-5/6 md:w-1/4">
          <div class="hiddenx md:block text-center pt-2">
            <div class="text-h4 text-bold text-gray-600">{{ title[step] }}</div>
            <div class="text-h6 mt-2" style="font-weight: 500;">{{ text[step] }}</div>
          </div>
        </div>
      </Transition>
      <Transition name="horizontal">
        <div class="flex flex-center h-full column" v-if="step==2">
          <img :src="img[step]" alt="" style="" class="pt-12 w-5/6 md:w-1/4">
          <div class="hiddenx md:block text-center pt-2">
            <div class="text-h4 text-bold text-gray-600">{{ title[step] }}</div>
            <div class="text-h6 mt-2" style="font-weight: 500;">{{ text[step] }}</div>
          </div>
        </div>
      </Transition>


    </div>
    <div  class=" relative bottom__section  " style="">
      <div class="w-full h-full  bottom__section--container md:px-2 px-8  relative ">
        <div class=" px-10 py-3 md:py-3 md:px-12 buttonNext"  @click="nextStep()" >
          {{ step==2 ? 'Finalizar' : 'Siguente' }} 
        </div>
        <div class="  paginationSteps">
          <div v-for="i in 3" :key="i" class="dotStep" :class="{'active': (step+1) == i }" />
        </div>
        <Transition name="horizontal">
          <div class="pt-16 " v-if="step==0">
              <div class=" text-center text-bold text-white" style="font-size: 1.25rem;">{{ title[step] }}</div>
              <div class=" text-justify text-subtitle1 mt-2 text-gray-300 mt-5" style="font-weight: 500;">{{ text[step] }}</div>
          </div>
        </Transition>
        <Transition name="horizontal">
          <div class="pt-10 " v-if="step==1">
              <div class=" text-center text-bold text-white" style="font-size: 1.25rem;">{{ title[step] }}</div>
              <div class=" text-justify text-subtitle1 mt-2 text-gray-300 mt-5" style="font-weight: 500;">{{ text[step] }}</div>
          </div>
        </Transition>
        <Transition name="horizontal">
          <div class="pt-10 " v-if="step==2">
              <div class=" text-center text-bold text-white" style="font-size: 1.25rem;">{{ title[step] }}</div>
              <div class=" text-justify text-subtitle1 mt-2 text-gray-300 mt-5" style="font-weight: 500;">{{ text[step] }}</div>
          </div>
        </Transition>
      </div>
    </div>
  </div>
</template>
<style lang="scss"> 
.paginationSteps{
  position: absolute;
  left: 1rem;
  bottom: 3.2rem;

  display: flex;
  & .dotStep{
    width: 0.65rem;
    height: 0.65rem;
    border-radius: 0.88rem;
    margin: 0px 0.2rem;
    background: white;
    transition: all 0.5s ease-in;
    &.active{
      width: 1.1rem;
    }
  }
}
.skip__button{
  border-radius: 15rem;
  transition: all 0.3s ease-in-out;
  
  &:hover{
    color: white;
    --tw-bg-opacity: 1;
    background-color: rgb(2 132 199 / var(--tw-bg-opacity, 1)); 
  }
}
.buttonNext{
  border-top-left-radius: 1rem;
  border-bottom-left-radius: 1rem;
  position: absolute;
  right: -0.5rem;
  top:-1.5rem;
  font-weight: 600;
  font-size: 1.1rem;
  box-shadow: 0px 0.2rem 1rem 0px rgb(155 155 155 / 53%);
  cursor: pointer;
  --tw-text-opacity: 1;
  color: rgb(2 132 199 / var(--tw-text-opacity, 1));
  background: white;
  transition: all 0.3s ease-in-out;

  &:hover{
    color: white;
    --tw-bg-opacity: 1;
    background-color: rgb(2 132 199 / var(--tw-bg-opacity, 1)); 
    transform: scale(1.05) translateX(-0.5rem);
  }

}
.tutorialSection{
  background-size: 100% 100%!important;
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
      --tw-bg-opacity: 1;
      background-color: rgb(2 132 199 / var(--tw-bg-opacity, 1));
      border-top-left-radius: 2.3rem; 
      border-top-right-radius: 2.3rem; 
      box-shadow: 0px -0.2rem 1rem 0px rgb(0 0 0 / 38%)
    }
  }
  .buttonNext{
    box-shadow: none;
    top: auto;
    bottom: 2rem;
    border-top-left-radius: 3rem;
    border-bottom-left-radius: 3rem;
    font-size: 1.2rem;

    &:hover{
      --tw-text-opacity: 1;
      color: rgb(2 132 199 / var(--tw-text-opacity, 1));
      background: white;
      transform: scale(1.05);
    }

  }
}
</style>
