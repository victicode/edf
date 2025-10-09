<script setup>
import { ref, onMounted } from 'vue';
import { useReserveStore } from '@/services/store/reserve.store';
import { useRouter } from 'vue-router';

const reserves = ref([]);
const ready = ref(false);
const reserveStore = useReserveStore();
const router = useRouter()
const getReserves = () => {
  reserveStore.getReservesByUser()
    .then((response) => {
      if (response.code !== 200) throw response;
      reserves.value = response.data;
      ready.value = true;
    })
    .catch((response) => {
      console.log(response);
    })
}

const goTo = (url) => {
  router.push(url)
}

onMounted(() => {
  getReserves();
})

</script>
<template>
  <div class="h-full" style="overflow: hidden;">
    <div style="height: 90%;" v-if="ready">
      <div v-if="reserves.length > 0">
        <div class="flex flex-center column py-24" v-for="reserve in reserves" :key="reserve.id">
          <div class="text-h6 text-primary mt-2">
            {{ reserve.date }}
          </div>
          <div class="text-h6 text-primary mt-2">
            {{ reserve.time_from }}
          </div>
          <div class="text-h6 text-primary mt-2">
            {{ reserve.time_to }}
          </div>
        </div>
      </div>
      <div class="flex flex-center column py-24 h-full" v-else>
        <q-icon name="eva-search-outline" size="3rem" color="primary" />
        <div class="text-h6 text-primary mt-2">
          No se encontraron reservas
        </div>
      </div>
    </div>

    <div class="flex flex-center column py-24" v-else style="height: 90%;">
      <q-spinner-dots color="primary" size="8rem" />
    </div>

    <div class="px-4  md:px-0 md:flex  md:justify-center items-center md:w-6/6" style="height: 10%;">

      <q-btn color="primary" unelevated class="w-full mt-0 md:mx-24 createBookingButton md:w-4/5"
        style="border-radius: 0.5rem;" @click="goTo('/client/reserves/form/add')">
        <div class="flex items-center py-2">
          <q-icon name="eva-plus-outline" />
          <div class="q-pt-xs text-bold pl-1">
            Agregar reserva
          </div>
        </div>
      </q-btn>
    </div>
  </div>
</template>

<style lang="scss">
.createBookingButton {
  width: 50%;
}

@media (max-width: 780px) {
  .createBookingButton {
    width: 100%;
  }
}
</style>