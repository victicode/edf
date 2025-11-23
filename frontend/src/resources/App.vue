<script setup>
import { useQuasar } from 'quasar';
import { onMounted } from 'vue';

const $q = useQuasar()

onMounted(() => {
  $q.addressbarColor.set('#0e344c');
})
</script>
<template>
  <q-layout view="hHh lpR fFf" style="overflow: hidden; height: 100vh;">
    <router-view class="appMobile " v-slot="{ Component }">
      <transition name="horizontal">
        <component :is="Component" />
      </transition>
    </router-view>
  </q-layout>

</template>
<style>
.appMobile {
  width: 100%;
  overflow: hidden;
  margin: auto;
  height: 100%;
}

@media (max-width: 780px) {
  .appMobile {
    width: 100%;
    border-radius: 0px;

  }
}
</style>