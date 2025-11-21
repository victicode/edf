<script setup>
import moment from 'moment';
import iconsApp from '@/assets/icons/index'
import { useRouter } from 'vue-router';
import { useAuthStore } from '@//services/store/auth.services';
import { storeToRefs } from 'pinia';
import { ref, watch } from 'vue';
moment.locale('es', {
  monthsShort: 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic'.split('_'),
  months: 'enero_febrero_marzo_abril_mayo_junio_julio_agosto_septiembre_octubre_noviembre_diciembre'.split('_'),
})
const props = defineProps({
  announces: {
    type: Array,
    default: []
  },
  myPost: Boolean
})
const isMyPost = ref(props.myPost)
const { user } = storeToRefs(useAuthStore()) 
const router = useRouter()
const dataContactFormat = (dataString) => {
  let {name} = JSON.parse(dataString);
  return name
}
const goTo = (id) => {
  router.push(`/client/notice/view/${id}`);
}
watch(() => props.myPost, (newValue) => {
  isMyPost.value = newValue
});

</script>
<template>
  <div v-if="announces.length > 0" class="space-y-5 md:px-5" >
    <div class="notice__item" v-for="announce in announces" :key="announce.id" >
      <div class="py-1 pl-4 pr-3 " @click="goTo(announce.id)">
        <div class="notices-badge px-3 ">
          Nuevo
        </div>
        <div class="notices-badgeStatus px-3" :class="'bg-'+announce.status_color" v-if="announce.user_id == user.id && isMyPost">
          {{ announce.status_label }}
        </div>
        <div>
          <div class="notice__item--title">{{announce.title}}</div>
          <div class="notice__item--description text-stone-400 my-1">
            {{ announce.description.substring(0,94) }}...
          </div>

        </div>
      </div>
      <div class="notice__item-bottom pl-4 flex items-center justify-between pr-3 py-2">
        <div class="notice__item-bottom--postBy" @click="goTo(announce.id)">
          Publicado por: {{dataContactFormat(announce.data_contact)}}
        </div>
        <div class="notice__item-bottom--dayPost flex items-center justify-between ">
          <div class="mr-2">
            {{ moment(announce.created_at).format('DD MMM YYYY') }}
          </div>
          <div  v-if="user.id == announce.user_id">
            <q-btn size="xs" round="" color="primary" flat="">
              <div v-html="iconsApp.optionsBook" />
              <q-menu>
                <q-list style="min-width: 150px">
                  <q-item clickable v-close-popup @click="showDialog($event)" data-dialog="cancel"
                    :data-reserve="announce.id">
                    <q-item-section>Borrar anuncio</q-item-section>
                  </q-item>
                  <q-separator />
                  <q-item clickable v-close-popup  @click="goTo('/client/reserves/pay-reserve/' + announce.id)">
                    <q-item-section>Editar anuncio</q-item-section>
                  </q-item>
                  <q-separator />
                </q-list>
              </q-menu>
            </q-btn>
          </div>
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