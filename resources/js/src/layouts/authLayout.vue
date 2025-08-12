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

</style>