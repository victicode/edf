<script setup>
  import { storeToRefs } from 'pinia';
  import { useAuthStore } from '@/services/store/auth.services';
  const { user } = storeToRefs(useAuthStore())

</script>

<template>
  <section class="md:px-8 pt-2 px-3 flex justify-between items-center bg-sky-600 header__container" style=" border-bottom-left-radius: 1.5rem; border-bottom-right-radius: 1.5rem;" >
    <div class="flex items-center">
      <div class="userAvatar flex flex-center">
        {{ user.name.charAt(0) }}
      </div>
      <div class="ml-3">
        <div class="text-white" style="font-size: 1rem;">
          Hola {{ user.name }}
        </div>
        <div class="text-gray-100 " style="font-size: 0.85rem;">
          P-201
        </div>
      </div>
    </div>
    <div>
      <q-icon name="notifications" color="white" size="1.6rem" />
    </div>
  </section>
</template>

<style lang="scss">
.header__container{
  box-shadow: 0px -0.1rem 1rem 0px rgb(0 0 0 / 38%);
}
.userAvatar{
  width: 2.7rem;
  height: 2.7rem;
  font-size: 1rem;
  font-weight: 700;
  border: 3px solid white;
  background: rgb(0, 104, 115);
  color: white;
  border-radius: 50%;
}
</style>