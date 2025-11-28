<script setup>
import { ref, onMounted } from 'vue';
import { useReserveStore } from '@/services/store/reserve.store';
import { useRouter } from 'vue-router';
import eventsList from '@/view/admin/Events/eventsList.vue';
const events = ref([]);
const loading = ref(false);
const reserveStore = useReserveStore();
const router = useRouter();
const dialog = ref('');
const selectedReserve = ref({})
const getReserves = () => {
  loading.value = true;
  reserveStore.getReservesByUser()
    .then((response) => {
      if (response.code !== 200) throw response;
      events.value = response.data;
    })
    .catch((response) => {
      console.log(response);
    })
    .finally(() => {
      loading.value = false;
    });
}
const getDialogData = (e) => {
  return e.target.closest('.q-item').dataset
}
const selectReserve = (id) => {
  selectedReserve.value = events.value.find(reserve => reserve.id == id)
}
const goTo = (url) => {
  router.push(url);
}



onMounted(() => {
  getReserves();
});
</script>

<template>
  <div class="h-full" style="overflow: hidden;">
    <div class="" style="height: 90%; overflow: auto;">
      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <!-- <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div> -->
        <q-spinner-dots color="primary" size="7rem" />

      </div>

      <!-- Content -->
      <div v-else class="px-4 py-6 md:px-28">
        <eventsList :events="events"/>
      </div>
    </div>
    <!-- Botón flotante para crear reserva -->
    <div class="px-4 md:flex  md:justify-center items-center md:w-full md:px-12" style="height: 10%;">
      <q-btn color="primary" unelevated class="w-full mt-0 md:mx-24 createBookingButton md:w-full"
        style="border-radius: 0.5rem; width: 100%;" @click="goTo('/client/events/form/add')">
        <div class="flex items-center py-2">
          <q-icon name="eva-plus-outline" />
          <div class="q-pt-xs text-bold pl-1">
            Agregar Evento
          </div>
        </div>
      </q-btn>
    </div>
    <template v-if="Object.values(selectedReserve).length > 0">
    </template>
  </div>
</template>
