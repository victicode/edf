<script setup>
import { Notify } from 'quasar'
import { ref, watch} from 'vue';
import { useRouter } from 'vue-router';
import { useReserveStore } from '@/services/store/reserve.store';
import { RadioGroup, Radio } from 'vant';

  const emit = defineEmits(['closeModal', 'updateList'])
  const reserveStore = useReserveStore()
  const props = defineProps({
    dialog: Boolean,
    // filters: Object
  })
  const router = useRouter()
  const loading = ref(false)
  const dialog  = ref(props)

  const hideModal = () => {
    emit('closeModal')
  }
  const filters = ref({
    status:4
  })
  const updateList = () => {
    emit('closeModal')
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

</script>
<template>
  <q-dialog v-model="dialog" class="filterDialog" persistent backdrop-filter="blur(0.5px)">
      <q-card class="dialog_document public py-2 md:py-2 ">
        <section class="content__modalSectionRifa md:mt-5 mt-0  py-2">
          <div class="text-2xl text-primary font-bold px-5">
            Filtar
          </div>
          <div class="row pt-3 pb-2 px-5">
            <div class="mb-1 text-lg font-medium text-primary">
              Estado de pago
            </div>
            <div class="col-12">
              <radio-group v-model="filters.status" class="row statusRadioGroup">
                <div class="col-12 my-2" >
                  <radio :name="0" icon-size="1.3rem" label-position="left">Canceladas</radio>
                </div>
                <div class="col-12 my-2" >
                  <radio :name="1" icon-size="1.3rem" label-position="left">Pendientes</radio>
                </div>
                <div class="col-12 my-2" >
                  <radio :name="2" icon-size="1.3rem" label-position="left">Pagos Pendientes</radio>

                </div>
                <div class="col-12 my-2" >
                  <radio :name="3" icon-size="1.3rem" label-position="left">Completas</radio>
                </div>
                <div class="col-12 my-2" >
                  <radio :name="4" icon-size="1.3rem" label-position="left">Todas</radio>
                </div>
              </radio-group>
            </div>
            
          </div>
          <div class="row pt-3 px-5" style="border-top: 1px solid lightgray;">
            <div class="mb-1 text-lg font-medium text-primary">
              Area reservada
            </div>
            <div class="col-12">

            </div>
            
          </div>
        </section>
        <section class="pb-5" style="border-top: 1px solid lightgray;">
          <div class="flex justify-evenly mt-5">
            <q-btn label="Restablecer"  unelevated class="q-mx-sm " color="primary" outline  style="border-radius: 0.8rem; padding:0px  2rem!important; font-size: 1rem;  " @click="hideModal()" />
            <q-btn label="Aplicar"  unelevated class="q-mx-sm " color="primary" outline  style="border-radius: 0.8rem; padding:0px  2rem!important; font-size: 1rem;  " :loading="loading" />
          </div>
        </section>
      </q-card>
  </q-dialog>
</template>
<style lang="scss">
.statusRadioGroup{
  & .van-radio__label {
    font-size: 1rem;
    font-weight: 500;
    color:rgb(53, 53, 53);
  }
  & .van-radio{
    justify-content: space-between;
  }
}
.filterDialog{
  margin-left: 0%;
  overflow: hidden;
  overflow: visible!important;
  position: relative;
  & .dialog_document{
    width: 100%;
    border-radius: 0rem !important;
    height: 100%;
    

  }
  & .q-dialog__inner--minimized{
    padding: 0px;
  }
}



@media (max-width: 780px) {
.filterDialog{
  & .dialog_document{
    max-height: 100%!important;
  }
}
}
</style>