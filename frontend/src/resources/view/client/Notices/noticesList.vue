<script setup>
import { ref, onMounted } from 'vue';
import { useNoticeStore } from '@/services/store/notice.store';
import { useRouter } from 'vue-router';
import NoticesList from '@/components/notices/noticesList.vue';
import AnnouncesList from '@/components/notices/announcesList.vue';
import createAnnouncesModal from '@/components/notices/createAnnouncesModal.vue';

const notices = ref([]);
const announces = ref([]);
const loading = ref(true);
const noticeStore = useNoticeStore();
const panelToShow = ref('notices')
const modal = ref('')
const fabRight = ref(false);
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
      notices.value = response.data.notices;
      announces.value = response.data.announces;

    })
    .catch((response) => {
      console.log(response);
    })
    .finally(() => {
      loading.value = false;
    });
}
const closeModal = () => {
  modal.value = ''
}

onMounted(() => {
  getNotices();
});
</script>

<template>
  <div class="h-full" style="overflow: hidden;">
    <!-- Lista de pagos -->
    <div class="h-full" style="overflow: auto; position: relative;">
      <div class="flex justify-center mt-3 bg-stone-200 py-2 buttonsContainer" >
        <div>
          <div class="buttonSwichtNotices  px-6 mx-3" :class="{'active':panelToShow == 'notices'}" @click="panelToShow ='notices'">
            Noticias
          </div>
        </div>
        <div>
          <div class="buttonSwichtNotices  px-6 mx-3" :class="{'active':panelToShow == 'announces'}" @click="panelToShow ='announces'">
            Anuncios
          </div>
        </div>
      </div>
      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <q-spinner-dots color="primary" size="7rem" />
      </div>

      <!-- Content -->
      <div v-else class="px-4 py-6 md:px-28">
        <!-- Lista de pagos -->
        <noticesList v-if="panelToShow == 'notices'" :notices="notices" />
        <announcesList v-if="panelToShow == 'announces'" :announces="announces" />
      </div>
      <div class="createAnnouncesFloat" v-if="panelToShow == 'announces'"  >
        <!-- <q-btn push color="primary" size="lg" round icon="eva-plus-outline" @click="modal='create_announce'" /> -->
        <q-fab
          v-model="fabRight"
          color="primary"
          size="lg"
          icon="eva-plus-outline"
          direction="up"
          v-if="panelToShow == 'announces'"
        >
          <q-fab-action class="announceOption" label-position="right" color="primary" icon="eva-plus-outline" label="Crear anuncio" @click="modal='create_announce'"/>
          <q-fab-action class="announceOption" label-position="right" color="secondary" icon="eva-archive-outline" label="Mis anuncios" />
        </q-fab>
      </div>
      <createAnnouncesModal :dialog="(modal=='create_announce')" @closeModal="closeModal" @updateList="getNotices()"/>
    </div>


  </div>
</template>

<style  lang="scss">
.announceOption{
  &.q-btn{
    transform: translateX(-34px) translateY(0px)!important;
  }
}
.createAnnouncesFloat{
  position: fixed;
  bottom: 3rem;
  right: 1rem;
}
.buttonsContainer{
  border-radius: 15px; 
  width: max-content; 
  margin-left: auto; margin-right: auto;
}
.buttonSwichtNotices{
  padding-top:0.39rem ;
  padding-bottom:0.39rem ;
  color: white;
  background: $primary;
  border-radius: 15px;
  opacity: 0.5;
  transition: all ease-in 0.54s;
  &:hover{
    opacity: 0.9;
  }
  &.active{
    opacity: 1;
  }
}
.notices-badge{
  position: absolute;
  background: $primary;
  color: white;
  font-size: 0.7rem;
  line-height: 1.7;
  top: 0;
  right: 0;
  border-bottom-left-radius: 7px;
}
.notice__item{
  background: white;
  border-radius: 7px;
  position: relative;
  height: max-content;
  overflow: hidden;
  box-shadow: 0px 1px 10px 1px #77777754;
  &::before{
    content: '';
    height: 100%;
    background: $primary;
    width: 6px;
    position: absolute;
  }
  &--title{
    font-size:0.95rem; font-weight: 500;
  }
  &--description{
    font-size:0.7rem; 
    font-weight: 400;
  }
  &-bottom{
    border-top: 1px dashed darkgray ;
  }
  &-bottom--postBy{
    font-size:0.75rem; 
    font-weight: 500;
  }
  &-bottom--dayPost{
    font-size:0.75rem; 
    font-weight: 500;
    color: #777;
  }
}
/* Estilos adicionales si es necesario */
</style>

