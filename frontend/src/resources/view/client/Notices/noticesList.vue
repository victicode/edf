<script setup>
import { ref, onMounted } from 'vue';
import { useNoticeStore } from '@/services/store/notice.store';
import { useRouter } from 'vue-router';
import moment from 'moment';

moment.locale('es', {
  monthsShort: 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic'.split('_'),
  months: 'enero_febrero_marzo_abril_mayo_junio_julio_agosto_septiembre_octubre_noviembre_diciembre'.split('_'),
})

const notices = ref([]);
const loading = ref(true);
const noticeStore = useNoticeStore();
const router = useRouter();
const dialog = ref(false);
const filters = ref({
  status: 4,
  notice_method: '',
  type: '',
  date_from: '',
  date_to: '',
  sort_by: 'created_at',
  sort_dir: 'desc'
});

const getNotices = () => {
  loading.value = true;
  noticeStore.getNotices(filters.value)
    .then((response) => {
      if (response.code !== 200) throw response;
      notices.value = response.data;
    })
    .catch((response) => {
      console.log(response);
    })
    .finally(() => {
      loading.value = false;
    });
}

const showDialog = () => {
  dialog.value = true;
}


onMounted(() => {
  getNotices();
});
</script>

<template>
  <div class="h-full" style="overflow: hidden;">
    <div class="flex justify-end pt-4 md:px-28 md:mx-5 mx-4">
      <q-btn
        outline
        color="primary"
        icon="eva-funnel-outline"
        @click="showDialog"
      />
    </div>
    <!-- Lista de pagos -->
    <div class="h-full" style="overflow: auto;">
      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <q-spinner-dots color="primary" size="7rem" />
      </div>

      <!-- Content -->
      <div v-else class="px-4 py-6 md:px-28">
        <!-- Lista de pagos -->
        <div v-if="notices.length > 0" class="space-y-3 md:px-5">
  
        </div>

        <!-- Estado vacío -->
        <div v-else class="flex flex-col items-center justify-center py-20">
          <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
              </path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes pagos</h3>
          <p class="text-gray-600 text-center mb-6">Aún no has realizado ningún pago.</p>
        </div>
      </div>
    </div>


  </div>
</template>

<style scoped>
.quotaItem{
  transition: all ease 0.5s;
  &:hover{
    opacity: 0.7;
  }
}
.titleQuota{
  transition: all ease 1s;
  &:hover{
    text-decoration: underline;
  }

}
/* Estilos adicionales si es necesario */
</style>

