<script setup>
import { useQuasar } from 'quasar';
import { onMounted } from 'vue';
const $q = useQuasar()

onMounted(() =>{
  $q.addressbarColor.set('#0284c7')
})
</script>
<template>
  <main  class="h-screen ">
    <RouterView class="appMobile "/>
  </main>
</template>
<style>
.appMobile{
  width: 100%;
  overflow: hidden;
  margin: auto;
  height: 100%;
}
@media (max-width: 780px) {
  .appMobile{
    width: 100%;
    border-radius: 0px;

  }
}

</style>