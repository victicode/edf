<script setup>
import { ref, watch } from 'vue';
import { useAuthStore } from '@/services/store/auth.services';
import { useRouter } from 'vue-router';
import { useNoticeStore } from '@//services/store/notice.store';

const noticeStore = useNoticeStore();
console.log(noticeStore)
const emit = defineEmits(['closeModal'])
const authStore = useAuthStore()
const props = defineProps({
  dialog: Boolean,
})
const router = useRouter()
const loading = ref(false)
const dialog = ref(props.dialog)
const formData = ref({
  title:'',
  description:'',
  group: {name:'ss1', value: 1},
  category: {name:'cs1', value: 1}

})
const groupOptions = [
  {name:'ss1', value: 1},
  {name:'ss2', value: 2},
  {name:'ss3', value: 3},
  {name:'ss4', value: 4},
]

const hideModal = () => {
  emit('closeModal')
}

const createAnnounce = () => {
  alert('si')
}
watch(() => props.dialog, (newValue) => {
  dialog.value = newValue
});

</script>
<template>
  <q-dialog v-model="dialog" class="createAnnounceDialog" persistent backdrop-filter="blur(0.5px)">
    <q-card class="dialog_document w-full " style="border-radius:1rem">
      <div>
        <q-card-section class="q-px-none">
          <div class="text-h6 text-center text-black pb-2 px-5" style="border-bottom: 1px solid lightgray;">
            Crear anuncio
          </div>
        </q-card-section>
        <section class="content__modalSectionRifa md:mt-5 py-5 ">
          <q-form
            @submit="createAnnounce()"
          >
          <div class="row w-full px-4" >
            <div class="col-md-6 col-12 mt-1 px-2 md:px-12">
              <div class="text-subtitle2 text-black">
                Titulo
              </div>
              <q-input
                  dense
                  borderless
                  clearable
                  v-model="formData.title"
                  class="form__inputsR mt-1"
                  color="primary"
                  :rules="[ val => val && val.length > 0 || 'Número de apartamento']"
                />
            </div>
            <div class="col-md-6 col-12 mt-1 px-2 md:px-12">
              <div class="text-subtitle2 text-black">
                Notas
              </div>
              <q-input
                dense
                borderless
                clearable
                type="textarea"
                v-model="formData.rules"
                class="form__inputsR mt-1"
                color="primary"
                  
                />
            </div>


          </div>
          </q-form>
        </section>
      </div>
      <section class="pb-5">
        <div class="flex justify-evenly mt-5">
          <q-btn label="Cerrar" unelevated class="q-mx-sm " color="primary" outline
            style="border-radius: 0.8rem; padding:0px  2rem!important; font-size: 1rem;  " @click="hideModal()" />
            
          <q-btn label="Publicar" unelevated class="q-mx-sm " color="primary" 
          style="border-radius: 0.8rem; padding:0px  2rem!important; font-size: 1rem;  " @click="hideModal()" />
        </div>
      </section>
    </q-card>
  </q-dialog>
</template>
<style lang="scss">
.createAnnounceDialog{
  max-height: 95dvh;
  & .q-dialog__inner{
    padding: 0px 0.8rem;
  }
}

.form__inputsR{
  & .q-field__inner {
    box-shadow: 0px 3px 4px 0px #bfbfbf48;
    border-radius: 0.5rem;
    border: 1px solid rgb(223, 223, 223);
    padding: 0px 1rem;
  }
}
@media (max-width: 780px) {
.form__inputsR{
  & .q-field__inner {

    padding: 0.1rem 1rem;
  }
}
}

</style>