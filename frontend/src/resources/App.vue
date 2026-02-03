<script setup>
import { useQuasar } from 'quasar';
import { onMounted, onUnmounted } from 'vue';
import { SplashScreen } from '@capacitor/splash-screen';
import { App } from '@capacitor/app';


const showSplash = async () => {
  await SplashScreen.show({
    autoHide: true,
    showDuration: 2000,
  })
}
const $q = useQuasar()
onMounted(async () => {
  $q.addressbarColor.set('#0e344c');
  showSplash();
  await App.addListener('backButton', ({ canGoBack }) => {
    if (canGoBack) {
      // Si hay historial en el stack de navegación, retrocedemos
      window.history.back();
    } else {
      // Si no hay a dónde ir atrás, cerramos la app
      App.exitApp();
    }
  });
});

onUnmounted(() => {
  // Es buena práctica eliminar todos los listeners al destruir el componente
  App.removeAllListeners();
});

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