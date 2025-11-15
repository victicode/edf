<script setup>
import moment from 'moment';
import iconsApp from '@/assets/icons/index'
moment.locale('es', {
  monthsShort: 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic'.split('_'),
  months: 'enero_febrero_marzo_abril_mayo_junio_julio_agosto_septiembre_octubre_noviembre_diciembre'.split('_'),
})
const props = defineProps({
  announces: {
    type: Array,
    default: []
  },
})
</script>
<template>
  <div v-if="announces.length > 0" class="space-y-3 md:px-5">
    <div class="notice__item" v-for="announce in announces" :key="announce.id">
      <div class="py-1 pl-4 pr-3">
        <div class="notices-badge px-3 ">
          Nuevo
        </div>
        <div>
          <div class="notice__item--title">{{announce.title}}</div>
          <div class="notice__item--description text-stone-400 my-1">
            {{ announce.description.substring(0,94) }}...
          </div>

        </div>
      </div>
      <div class="notice__item-bottom pl-4 flex items-center justify-between pr-3 py-2">
        <div class="notice__item-bottom--postBy">
          Publicado por: {{'Admin'}}
        </div>
        <div class="notice__item-bottom--dayPost">
          {{ moment(announce.created_at).format('DD MMM YYYY') }}
        </div>
      </div>
    </div>
  </div>
  <!-- Estado vacío -->
  <div v-else class="flex flex-col items-center justify-center py-20">
    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-6">
      <div v-html="iconsApp.megaphone" />
    </div>
    <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay anuncios que mostrar</h3>
    <p class="text-gray-600 text-center mb-6">En breve te traemos más informacion.</p>
  </div>
</template>