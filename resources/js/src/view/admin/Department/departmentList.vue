<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import iconsApp from '@/assets/icons/index'


const tabActive = ref('users')
const changeTab = (tab) => {
  tabActive.value = tab
}
const modal = ref('')
const router = useRouter()
const goTo = (url) => {
  router.push(url)
}
</script>

<template>
  <div class="">
    <!-- <div class="flex mt-5 justify-between  md:mx-auto items-center md:w-2/6 bg-primary mx-4 " style=" height: 2.8rem; overflow: hidden;border-radius: 0.7rem; ">
      
    </div> -->
    <div class="px-4 md:px-0 md:flex md:mx-auto md:justify-end md:w-5/6">
      <q-btn color="primary" unelevated class="w-full mt-5 md:mx-5 createButton " style="border-radius: 0.5rem;" @click="goTo('/admin/users/form/add')">
        <div class="flex items-center py-1" >
          <q-icon name="eva-plus-outline"/>
          <div class="q-pt-xs text-bold pl-1">
            Agregar departamento
          </div>
        </div>
      </q-btn>
    </div>
    <div class="mt-5 px-2">
      <div class="flex items-end justify-between p-2 py-3  apartamentContainer relative" style="">
        <div class="flex">
          <div class="imgItem__container ">
            <div v-html="iconsApp.apartment" class="flex flex-center px-0 h-full"/>
          </div>
          <div class="px-2">
            <div class=" text-bold  text-black" style="font-weight: bold; font-size: 1.3rem;"> 
             #A-12
            </div>
            <div class="mt-1" style="font-weight: 500; font-size: 0.89rem;">
              Ubicación: P1
            </div>
            <div class="mt-1" style="font-weight: 500; font-size: 0.89rem;">
              Area: 65MT²
            </div>
          </div>
        </div>
        <div class="flex pr-8">
          <div>

            <q-btn icon="eva-settings-outline"  color="primary" round  />
          </div>
        </div>
        <div class="availableBadge px-8 py-1">
          Disponible
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="scss">
.availableBadge{
  background: $positive;
  color: white;
  font-size: 0.9rem;
  top: 1.2rem;
  right: -2rem;
  position: absolute;
  // border-bottom-left-radius: 0.8rem;
  transform: rotate(45deg);
}
.imgItem__container{
  width: 4.2rem; 
  height: 4.2rem; 
  border-radius: 0.8rem; 
  background: $primary;
}
.apartamentContainer{
  overflow: hidden;
  border-radius: .5rem;
  box-shadow: 0px 2px 6px 0px rgb(199, 199, 199);
}
.createButton{
  width: auto;
}
.tabItem {
  opacity: 0.5;
  cursor: pointer;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: all 0.2s ease-out;
  &:hover{
    background: #279edb!important;
  }
  &.active{
    opacity: 1;
  }
  &.leftItem{
    border-top-left-radius: 0.7rem;
    border-bottom-left-radius: 0.7rem;

  }
  &.rightItem{
    border-top-right-radius: 0.7rem;
    border-bottom-right-radius: 0.7rem;

  }
}
@media (max-width: 780px) {
  .createButton{
    width: 100%;
  }
}

</style>
