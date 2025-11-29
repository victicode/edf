<script setup>
import iconsApp from '@/assets/icons/index'
import moment from 'moment';
// import cancelReserveModal from '@/components/events/cancelReserveModal.vue';

moment.locale('es', {
  monthsShort: 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic'.split('_'),
  months: 'enero_febrero_marzo_abril_mayo_junio_julio_agosto_septiembre_octubre_noviembre_diciembre'.split(
    '_'
  ),
})

const emit = defineEmits(['openModal'])
const props = defineProps({
  events: {
    type: Array,
    default: []
  },
})
const goTo = (url) => {
  router.push(url);
}

const showDialog = (e) => {
  const dialogData = getDialogData(e)
  selectReserve(dialogData.reserve)
  setTimeout(() => {
    dialog.value = dialogData.dialog;
  }, 500);
}
const formatLocation = (event) => {
  let location = event.location || event?.booking?.comun_area.name

  return location || '---'
}

const getPaymentAmount = (booking) => {
  if (booking.amount > 0) {
    return `S/. ${booking.amount}`;
  }
  return 'Gratis';
}

</script>
<template>
   <!-- Lista de reservas -->
   <div v-if="events.length > 0" class="space-y-3 md:px-5">
      <div v-for="event in events" :key="event.id"
        class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden md:mb-5"
        style="position: relative;">

        <!-- Sección superior - Detalles de la reserva -->
        <div class="md:px-4 md:pb-4 pb-2 px-3 pt-2  border-gray-300">
          <!-- Header con nombre y estado -->
          <div class="flex justify-between items-start mb-1">
            <div class="flex-1">
              <h3 class="text-lg font-bold text-gray-900 mb-1">
                {{ event.title || 'Evento' }}
              </h3>
            </div>
          </div>

          <!-- Contenido principal con imagen y detalles -->
          <div class="flex items-center space-x-4">
            <!-- Imagen del área -->
            <div class="w-16 h-16 bg-gray-200 rounded-xl flex items-center justify-center flex-shrink-0">
              <div v-html="iconsApp['events']" />
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
                <span class="font-medium">{{ moment(event.date).format('DD MMM YYYY') }}</span>
              </div>

              <!-- Horario -->
              <div class="flex items-center text-sm text-gray-700">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">
                  {{ event.time_from }} - {{ event.time_to }}
                </span>
              </div>
              <div class="flex items-center text-sm text-gray-700">
                <div v-html="iconsApp.location" />
                <span class="font-medium">
                  {{ formatLocation(event) }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Sección inferior - Estado de pago -->
        <div class="md:px-4 md:py-4 pb-3 px-3 bg-gray-50">
          <div class="flex justify-end items-center">
            <div flat rounded color="primary" size="sm" class="ml-3 cursor-pointer">
              <div v-html="iconsApp.optionsBook" />
              <q-menu>
                <q-list style="min-width: 150px">
                  <q-item clickable v-close-popup @click="goTo('/client/events/view/' + event.id)">
                    <q-item-section>Ver detalles</q-item-section>
                  </q-item>
                  <q-item clickable v-close-popup @click="showDialog($event)" data-dialog="cancel"
                    :data-event="event.id">
                    <q-item-section>Eliminar evento</q-item-section>
                  </q-item>
                  <q-separator />
                </q-list>
              </q-menu>
            </div>
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
      <button @click="goTo('/client/events/form/add')"
        class="px-6 py-3 bg-blue-600 text-white rounded-full font-medium hover:bg-blue-700 transition-colors">
        Crear primer reserva
      </button>
    </div>
</template>
<style scoped>
/* Estilos adicionales si es necesario */
.badgeEvents {
  position: absolute;
  right: 0;
  border-bottom-left-radius: 0.5rem;
  top: 0;
}
</style>