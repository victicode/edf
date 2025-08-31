<script setup>
import { onMounted, ref, watch} from 'vue';
import { Notify } from 'quasar'
import { useUserStore } from '@/services/store/users.store';

  const userStore = useUserStore()
  const emit = defineEmits(['closeModal', 'updateList'])
  const props = defineProps({
    dialog: Boolean,
    rifa: Object,
  })

  const dialog    = ref(props.dialog); 
  const rifa = ref()
  const loading   = ref(false)
  const hideModal = () => {
    
    emit('closeModal')
  }
  const updateRifa = () => {
    hideModal()
    emit('updateList')
  }
  const showNotify = (type,text) => {
    Notify.create({
      color:type,
      message: text,
      timeout:2000
    })
  }

  
  watch(() => props.dialog, (newValue) => {
    dialog.value = newValue
  });

  onMounted(() => {
  })
  
</script>
<template>
   <q-dialog v-model="dialog" class="createUserModal" persistent backdrop-filter="blur(8px)">
      <q-card class="dialog_documentCard" style="border-radius:1rem">
        <div class="close__button">
          <q-btn round color="primary" icon="close" @click="hideModal()" />
        </div>
        <q-form
          class="md:px-5 pb-5 "
          style="height: 100%; "
          @submit="deleteRifa()"
        >
          <div>
            <q-card-section class="">
              <div class="text-h6 text-center text-black">
                Borrar Rifa
              </div>
            </q-card-section>
            <section class="content__modalSectionRifa md:mt-5 mt-0">
              <q-card-section class="q-pt-none q-px-sm ">
                <div class="px-2">
                   <div class="text-h6 text-center text-black text-bold">
                    ¿Seguro que deseas borrar la rifa "{{  }}"?
                  </div>

                </div>
              </q-card-section>
            </section>
          </div>
          <section>
            <div class="flex justify-evenly mt-5">
              <q-btn label="Cerrar"  color="black"  class="q-mx-sm " style="width: 55%; border-radius: 0.8rem; padding: 0.7rem 0px;" @click="hideModal()" />
              <q-btn label="Borrar"  color="negative" type="submit" style="width: 35%; border-radius: 0.8rem; padding: 0.7rem 0px;" :loading="loading"/>
            </div>
          </section>
        </q-form>
      </q-card>
    </q-dialog>
</template>
<style lang="scss">

.deleteRifaForm__input {
  & .q-field__control {
    border-radius: 10px!important;

  }
  & .q-field__label{
    transform: translateY(11%)
  }
  &.q-field--focused .q-field__label, &.q-field--float .q-field__label{
    z-index: 100;
    background: white!important;
    font-weight: 600;
    max-width: 133%;
    padding: 0px 10px;
    transform: translateY(-125%) translateX(0%) scale(0.75)!important;
  }
  
  & .q-field__native{
    padding-top: 15px!important;
    font-weight: 600;
  }
  & .q-field__append{
    transform: translateY(5%)
  }
}
.overflow__img{
  opacity: 0;
  position: absolute; 
  top:0; bottom:0; left:0; right:0; 
  background:rgba(34, 34, 34, 0.539);
  border-radius: 1rem;
  transition: all 0.5 ease;
}
.dialog_documentCard {
  margin-left: 10%;
  min-width: 600px!important;
  max-width: 800px!important; 
  overflow: visible!important;
  position: relative;
}
@media (max-width: 768px){
  

  .createUserModal .q-dialog__inner--minimized{
    padding: 24px 1rem;
  }
  .dialog_documentCard {
    margin-left: 0%;
    min-width: 100%!important;
    max-width: 800px!important; 
  }
}
</style>