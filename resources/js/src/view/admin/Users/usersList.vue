<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/services/store/users.store';

const userStore = useUserStore()
const tabActive = ref('users')
const page = ref(1)
const search = ref('')
const ready = ref(false)

const changeTab = (tab) => {
  tabActive.value = tab
  getUsers()
}
const router = useRouter()

const goTo = (url) => {
  router.push(url)
}

const users = ref([])

const getUsers = () => {

  ready.value =  false;

  const data = {
    page: page.value,
    search: search.value,
    rol: tabActive.value == 'users' ? 2 : 1
  }
  userStore.getUsers(data)
  .then((response) =>{
    if(response.code !== 200) throw response
    users.value = response.data;
    setTimeout(() => {
      ready.value =  true;
    }, 1000);
  })
  .catch(() =>{
  })
}

onMounted(() => {
  getUsers()
})
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
    <div class="mt-4">
      <div class="px-4">
        <div v-for="user in users" :key="user.id" class="px-2 py-3 mb-5 userListContainer flex items-center justify-between">
          <div class="flex items-center">
            <div style="height: 2.8rem; width: 2.8rem; background: #b5b5b5; border-radius: 0.5rem; font-size: 2rem; font-weight: bold;" class="flex flex-center text-white">
              {{ user.name.charAt(0).toUpperCase() }}
            </div>
            <div class="ml-2">
              <div class="text-subtitle1 text-bold text-black" style="line-height:1.7;">{{ user.name }}</div>
              <div class="text-body2 text-grey-6 ">{{  user.apartaments.length > 0 ?  user.apartaments[0].number : 'Apt. no asignado'}}</div>
            </div>
          </div>
          <div class="flex justify-end py-1">
            <div v-if="user.apartaments.length  == 0">
              <q-btn icon="add_home_work" class="mx-1" flat color="primary" round size="0.75rem" />
            </div>
            <div>
              <q-btn icon="eva-settings-outline" class="mx-1" flat color="primary" round size="0.75rem" />
            </div>
            <div>
              <q-btn icon="eva-trash-2-outline" class="mx-1" flat color="negative" round size="0.75rem" />
            </div>
            
          </div>
        </div>
      </div>

    </div>
  </div>
</template>
<style lang="scss">
.userListContainer{
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
