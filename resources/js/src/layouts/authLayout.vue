<template>
  <section class="h-full authContainer">
    <router-view v-slot="{ Component }">
      <transition name="fade">
        <component :is="Component" />
      </transition>
    </router-view>
  </section>
</template>
<style>
.authContainer {
  /* background: linear-gradient(90deg, rgba(0,29,255,1) 0%, rgba(48,30,201,1) 30%, rgba(74,9,121,1) 86%); */
}

</style>