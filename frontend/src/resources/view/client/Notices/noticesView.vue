<script setup>
import { useNoticeStore } from '@/services/store/notice.store';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import iconsApp from '@/assets/icons/index'

const ready = ref(false)
const notice = ref({})
const route = useRoute()
const getNoticesById = () => {
  ready.value = false
  useNoticeStore().getNoticeById(route.params.id)
  .then((data) => {
    Object.assign(notice.value, data.data);
  })
  .catch((response) => {
    console.log(response)
  })
  .finally(() => {
    ready.value = true
  })
}
const dataContactFormat = (dataString) => {
  let {name, apartment} = JSON.parse(dataString);
  return `${name} - ${apartment}`
}
const setInViewUser = () => {
  useNoticeStore().setViewer(route.params.id)
}
onMounted(() => {
  setInViewUser()
  getNoticesById()
})
</script>
<template>
  <section class="h-full" style="overflow: hidden;">
    <div v-if="ready">
      <div v-if="Object.values(notice).length > 0" class="px-4">
        <div class="mt-4 text-h6 text-primary font-bold">
          ► {{ notice.title }}
        </div>
        <div class="mt-4 text-sm text-stone-600" style="line-height: 1.5;">
          {{ notice.description }}
        </div>
        <div>
          
        </div>
        <div class="mt-4 text-xs text-stone-400" style="line-height: 1.5;">
          Publicado por: {{ notice.type == 1 ? 'Administrador' : dataContactFormat(notice.data_contact) }}
        </div>
      </div>
      <div v-else class="flex flex-col items-center justify-center py-20">
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-6">
          <div v-html="iconsApp.megaphone" />
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Error al intentar obtener noticia</h3>
        <p class="text-primary text-center mb-6" style="text-decoration: underline;" @click="getNoticesById()">Reintentar.</p>
      </div>
    </div>
    <div v-else class="flex justify-center column items-center py-20">
      <q-spinner-comment color="primary" size="5rem" />
      <div class="text-stone-500 text-center mx-12">Cargando información</div>
    </div>
  </section>
</template>