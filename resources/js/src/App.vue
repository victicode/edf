<script setup>
import { useQuasar } from 'quasar';
import { onMounted } from 'vue';

const $q = useQuasar()

onMounted(() => {
  $q.addressbarColor.set('#0e344c');
})
</script>
<template>
  <main class=" w-full" style="overflow: hidden; height: 100dvh;">

    <router-view class="appMobile " v-slot="{ Component }">
      <transition name="horizontal">
        <component :is="Component" />
      </transition>
    </router-view>
  </main>
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