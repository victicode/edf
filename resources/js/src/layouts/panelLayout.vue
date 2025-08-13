<script setup>
import headerLayout from '@/components/layout/headerLayout.vue';
import infoNewSideBar from '@/components/layout/infoNewSideBar.vue';
</script>
<template>
  <div class="h-full bg-stone-100 w-full" style="position: relative; overflow: hidden;">

    <headerLayout class="header__container" />
    <section class="page__container">
      
      <router-view v-slot="{ Component }">
        <transition name="fade">
          <component :is="Component" />
        </transition>
      </router-view>
    </section>
    <infoNewSideBar />


  </div>
</template>

<style lang="scss">
.header__container{
  height: 12%;
  overflow: hidden;
}
.page__container{
  height: 88%;
  overflow: auto;
}
</style>
