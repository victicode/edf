<script setup>
import headerLayout from '@/components/layout/headerLayout.vue';

</script>
<template>
  <div class="h-full">

    <headerLayout class="header__container" />
    <section class="page__container">
      
      <router-view v-slot="{ Component }">
        <transition name="fade">
          <component :is="Component" />
        </transition>
      </router-view>
    </section>

  </div>
</template>

<style lang="scss">
.header__container{
  height: 12%;
  overflow: hidden;
}
.page__container{
  height: 188%;
  overflow: auto;
}
</style>
