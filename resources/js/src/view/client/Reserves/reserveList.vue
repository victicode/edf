<script setup>
import { useRouter } from 'vue-router';
  const router = useRouter()
  const goTo = (url) => {
    router.push(url) 
  }
</script>
<template>
  <div class="h-full"  style="overflow: hidden;">
    <div style="height: 90%; ">
      <div class="flex flex-center column py-24">
        <q-icon name="eva-search-outline" size="3rem" color="primary" />
        <div class="text-h6 text-primary mt-2">
          No se encontraron reservas
        </div>
      </div>
    </div>
    <div class="px-4  md:px-0 md:flex  md:justify-center items-center md:w-6/6" style="height: 10%;">
      <q-btn color="primary" unelevated class="w-full mt-0 md:mx-24 createBookingButton md:w-4/5" style="border-radius: 0.5rem;" @click="goTo('/client/reserves/form/add')" >
        <div class="flex items-center py-1" >
          <q-icon name="eva-plus-outline"/>
          <div class="q-pt-xs text-bold pl-1">
            Agregar reserva
          </div>
        </div>
      </q-btn>
    </div>
  </div>
</template>

<style lang="scss">
.createBookingButton{
  width: 80%;
}
@media screen and (max-width: 820px){
  .createBookingButton{
    width: 100%;
  }
}
</style>