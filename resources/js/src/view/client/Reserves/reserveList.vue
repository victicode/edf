<script setup>
import { ref, onMounted } from 'vue';
import { useReserveStore } from '@/services/store/reserve.store';
import { useRouter } from 'vue-router';
import iconsApp from '@/assets/icons/index'

const reserves = ref([]);
const loading = ref(false);
const reserveStore = useReserveStore();
const router = useRouter();

const getReserves = () => {
  loading.value = true;
  reserveStore.getReservesByUser()
    .then((response) => {
      if (response.code !== 200) throw response;
      reserves.value = response.data;
    })
    .catch((response) => {
      console.log(response);
    })
    .finally(() => {
      loading.value = false;
    });
}

const goTo = (url) => {
  router.push(url);
}

const goBack = () => {
  router.go(-1);
}

const getStatusColor = (status) => {
  const colors = {
    0: 'bg-red-500', // Cancelada
    1: 'bg-orange-500', // Pago pendiente
    2: 'bg-yellow-500', // Pendiente de aprob.
    3: 'bg-green-500' // Exitoso
  };
  return colors[status] || 'bg-gray-500';
}

const getStatusText = (status) => {
  const statuses = {
    0: 'Cancelada',
    1: 'Pago pendiente',
    2: 'Pendiente de aprob.',
    3: 'Confirmada'
  };
  return statuses[status] || 'Desconocido';
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
}

const formatTime = (time) => {
  return time;
}

const getPaymentStatus = (booking) => {
  if (booking.amount > 0) {
    return booking.pay_method == 1 ? 'Pagado vía Transferencia' :
      booking.pay_method == 2 ? 'Pagado vía Efectivo' : 'Pagado';
  }
  return 'Sin pago';
}

const getPaymentAmount = (booking) => {
  if (booking.amount > 0) {
    return `S/. ${booking.amount}`;
  }
  return 'Gratis';
}

onMounted(() => {
  getReserves();
});
</script>

<template>
  <div class="h-full">

    <div class="" style="height: 90%;">

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Content -->
      <div v-else class="px-4 py-6">
        <!-- Lista de reservas -->
        <div v-if="reserves.length > 0" class="space-y-3">
          <div v-for="reserve in reserves" :key="reserve.id"
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" style="position: relative;">

            <!-- Sección superior - Detalles de la reserva -->
            <div class="px-4 pb-4 pt-2 border-b border-dashed border-gray-300">
              <!-- Header con nombre y estado -->
              <div class="flex justify-between items-start mb-2">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    {{ reserve.comun_area?.name || 'Área Común' }}
                  </h3>
                </div>
                <!-- Estado badge -->
                <span :class="getStatusColor(reserve.status)"
                  class="inline-block px-3 py-2 text-xs font-bold text-white badgeReserve">
                  {{ getStatusText(reserve.status) }}
                </span>
              </div>

              <!-- Contenido principal con imagen y detalles -->
              <div class="flex items-center space-x-4">
                <!-- Imagen del área -->
                <div class="w-16 h-16 bg-gray-200 rounded-xl flex items-center justify-center flex-shrink-0">
                  <div v-html="iconsApp[reserve.comun_area.icon]" />
                </div>

                <!-- Detalles de la reserva -->
                <div class="flex-1 space-y-2">
                  <!-- Fechas -->
                  <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                      </path>
                    </svg>
                    <span class="font-medium">{{ formatDate(reserve.date) }}</span>
                  </div>

                  <!-- Horario -->
                  <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">
                      {{ formatTime(reserve.time_from) }} - {{ formatTime(reserve.time_to) }}
                    </span>
                  </div>

                  <!-- Confirmado por -->
                  <!-- <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-medium">Confirmado por: {{ reserve.user?.name || 'Usuario' }}</span>
                  </div> -->
                </div>
              </div>
            </div>

            <!-- Sección inferior - Estado de pago -->
            <div class="p-4 bg-gray-50">
              <div class="flex justify-between items-center">
                <div class="flex items-center">
                  <svg v-if="reserve.amount > 0" class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                  <svg v-else class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                  </svg>
                  <span class="text-sm font-medium text-gray-700">{{ getPaymentStatus(reserve) }}</span>
                </div>
                <span class="text-sm font-bold text-gray-900">
                  {{ getPaymentAmount(reserve) }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Estado vacío -->
        <div v-else class="flex flex-col items-center justify-center py-20">
          <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes reservas</h3>
          <p class="text-gray-600 text-center mb-6">Aún no has realizado ninguna reserva de áreas comunes.</p>
          <button @click="goTo('/client/reserves/form/add')"
            class="px-6 py-3 bg-blue-600 text-white rounded-full font-medium hover:bg-blue-700 transition-colors">
            Crear primera reserva
          </button>
        </div>
      </div>
    </div>

    <!-- Botón flotante para crear reserva -->
    <div class="px-4  md:px-0 md:flex  md:justify-center items-center md:w-full" style="height: 10%;">
      <q-btn color="primary" unelevated class="w-full mt-0 md:mx-24 createBookingButton md:w-full"
        style="border-radius: 0.5rem; width: 100%;" @click="goTo('/client/reserves/form/add')">
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

<style scoped>
/* Estilos adicionales si es necesario */
.badgeReserve {
  position: absolute;
  right: 0;
  border-bottom-left-radius: 0.5rem;
  top: 0;
}
</style>