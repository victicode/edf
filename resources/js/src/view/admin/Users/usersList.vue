<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';


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
    <div class="flex mt-5 justify-between  md:mx-auto items-center md:w-2/6 bg-primary mx-4 " style=" height: 2.8rem; overflow: hidden;border-radius: 0.7rem; ">
      <div class="text-subtitle1 text-bold text-white text-center bg-primary tabItem leftItem" @click="changeTab('users')" :class="{'active':tabActive == 'users'}" style="width: calc(50% - 1px);" >Usuarios</div>
      <div style="height: 100%; width: 2px; background: lightcyan; width: 2px;" />
      <div class="text-subtitle1 text-bold text-white text-center bg-primary tabItem rightItem" @click="changeTab('admin')" :class="{'active':tabActive == 'admin'}" style="width: calc(50% - 1px);" >Administradores</div>
    </div>
    <div class="px-4 md:px-0 md:flex md:mx-auto md:justify-end md:w-5/6">
      <q-btn color="primary" unelevated class="w-full mt-5 md:mx-5 createButton " style="border-radius: 0.5rem;" @click="goTo('/admin/users/form/add')">
        <div class="flex items-center py-1" >
          <q-icon name="eva-plus-outline"/>
          <div class="q-pt-xs text-bold pl-1">
            Crear nuevo usuario
          </div>
        </div>
      </q-btn>
    </div>
    <div class="mt-5">

    </div>
  </div>
</template>
<style lang="scss">

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
