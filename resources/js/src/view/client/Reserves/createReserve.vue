<script setup>
import { onMounted, ref, inject} from 'vue';
import { Notify } from 'quasar'
import { useRouter, useRoute } from 'vue-router';
import { useComunAreaStore } from '@/services/store/comunArea.store';

  const comunAreaStore = useComunAreaStore()
  const emitter = inject('emitter')
  const comunAreas = ref([])
  const comunArea = ref({})
  const router = useRouter()
  const route = useRoute()
  const ready = ref(false)
  const loading = ref(false)
  const step = ref(1)
  const formData = ref({
    date: '',
    time_from: '',
    time_to: '',
    amount: 0,
    vaucher: '',
    reference: '',
    note: '',
    pay_method: '',

  })

  const selectArea = (id) => {
    comunArea.value = comunAreas.value.find((area) => area.id == id )
    nextStep()
  }
  const backButton = () => {
    step.value--
    emitter.emit('pagTitle', 'Selecciona area común')


  } 
  const nextStep = () => {
    if(step.value == 3) {
      createReserve()
      return
    }
    emitter.emit('pagTitle', step.value == 1 ? 'Agenda tu reserva' : 'Realiza el pago')
    step.value++

  }
  const getComunsArea = () => {
    emitter.emit('pagTitle', 'Selecciona area común')
    comunAreaStore.getAllComunAreas()
    .then((response) => {
      if(response.code !== 200) throw response 

      comunAreas.value = response.data
      setTimeout(()=>{
        ready.value = true
      },100)
    })
    .catch((response) =>{
      showNotify('positive', 'Error al obtener areas comunes')
    })
  }

  const showNotify = (type,text) => {
    Notify.create({
      color:type,
      message: text,
      timeout:2000
    })
  }


  onMounted(() => {
    getComunsArea()
  })
  
</script>
<template>
<div class="md:px-20 md:mx-16  h-full " style="overflow: hidden; position: relative;">
  <div class="h-full" v-if="ready">
    <q-form
      @submit="nextStep()"
      class="h-full "
    >
      <Transition name="horizontal">
        <div class="px-3 pt-5" v-if="step == 1">
          <div v-for="comunArea in comunAreas" class="row selectAreaItem items-center mb-5 px-4 py-3" :key="comunArea.id"  @click="selectArea(comunArea.id)">
            <div class="col-10">
              <div class="text-subtitle1 text-black q-mt-xs" style="line-height: 1.2; font-weight: 500;">{{ comunArea.name }}</div>
              <div class="q-mt-xs text-body2" style="font-weight: 500;">
                Costo: S/{{ comunArea.price }} 
                <i v-if="comunArea.warranty_price > 0">
                  + S/{{ comunArea.warranty_price }} 
                  <span class="text-warning" style="font-size: 0.75rem;">garantia</span>
                </i>
              </div>
            </div>
            <div class="col-2 text-bold" style="font-size: 0.988rem;" :class="{'text-positive': comunArea.pay_label == 'Gratis', 'text-primary': comunArea.pay_label == 'Pago'}">
              {{ comunArea.pay_label }}
            </div>
          </div>
        </div>
      </Transition>
      <Transition name="horizontal">
        <div class="h-full " style="overflow: auto;" v-if="step == 2">
          
            <div class=" w-full h-full " >
              <div style="height: 90%;">
                <div class="row w-full pt-5">
                  <div class="col-12 px-4">
                    <div class="w-full row selectAreaItem items-center mb-5 px-4 py-3">
                      <div class="col-10">
                        <div class="text-subtitle1 text-black q-mt-xs" style="line-height: 1.2; font-weight: 500;">{{ comunArea.name }}</div>
                        <div class="q-mt-xs text-body2" style="font-weight: 500;">
                          Costo: S/{{ comunArea.price }} 
                          <i v-if="comunArea.warranty_price > 0">
                            + S/{{ comunArea.warranty_price }} 
                            <span class="text-warning" style="font-size: 0.75rem;">garantia</span>
                          </i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12  text-subtitle1 headerSection my-1 py-2 px-4">
                    Selecciona la fecha
                  </div>
                  <div class="col-md-6 col-12 row mt-1 px-3 md:px-12">
                    <div class="col-12 mt-3">
                      <div class="text-subtitle2 text-black ">
                        Maximo de horas de reserva
                      </div>
                      <q-input v-model="formData.date" mask="date" :rules="['date']" dense
                        borderless
                        clearable
                        class="form__inputsReverse mt-1"
                        color="primary"
                      >
                        <template v-slot:append>
                          <q-icon name="eva-calendar-outline" class="cursor-pointer">
                            <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                              <q-date v-model="formData.date">
                                <div class="row items-center justify-end">
                                  <q-btn v-close-popup label="Aceptar" color="primary" flat />
                                </div>
                              </q-date>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>
                  </div>
                  <div class="col-12  text-subtitle1 headerSection my-1 py-2 px-4">
                    Selecciona la hora
                  </div>
                  <div class="col-md-6 col-12 row  px-3 md:px-12">
                    <div class="col-12 mt-3">
                      <div class="text-subtitle2 text-black">
                        Horas disponibles:
                      </div>
                      <div class="row w-full mt-4">
                        <div class="col-6  pr-2 md:pr-4">
                          <div class="text-body2 text-black" style="font-weight: medium;">
                            Desde:
                          </div>
                          <q-input v-model="formData.time_from" mask="time" :rules="['time']" dense
                            borderless
                            clearable
                            class="form__inputsReverse mt-1"
                            color="primary"
                          >
                            <template v-slot:append>
                              <q-icon name="eva-clock-outline" class="cursor-pointer">
                                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                  <q-time v-model="formData.time_from">
                                    <div class="row items-center justify-end">
                                      <q-btn v-close-popup label="Aceptar" color="primary" flat />
                                    </div>
                                  </q-time>
                                </q-popup-proxy>
                              </q-icon>
                            </template>
                          </q-input>
        
                        </div>
                        <div class="col-6  pl-2 md:pl-4">
                          <div class="text-body2 text-black" style="font-weight: medium;">
                            Hasta:
                          </div>
                          <q-input v-model="formData.time_to" mask="time" :rules="['time']" dense
                            borderless
                            clearable
                            class="form__inputsReverse mt-1"
                            color="primary"
                          >
                            <template v-slot:append>
                              <q-icon name="eva-clock-outline" class="cursor-pointer">
                                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                  <q-time v-model="formData.time_to">
                                    <div class="row items-center justify-end">
                                      <q-btn v-close-popup label="Aceptar" color="primary" flat />
                                    </div>
                                  </q-time>
                                </q-popup-proxy>
                              </q-icon>
                            </template>
                          </q-input>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-12  text-subtitle1 headerSection my-1 py-2 px-4">
                    Datos adicionales
                  </div> -->
                  <!-- <div class="col-md-6 col-12 pt-3 px-3 md:px-12">
                    <div class="text-subtitle2 text-black">
                      Normas
                    </div>
                    <q-input
                        dense
                        borderless
                        clearable
                        type="textarea"
                        v-model="formData.note"
                        class="form__inputsReverse mt-1"
                        color="primary"
                        :rules="[ val => val && val.length > 0 || 'Indica las reglas']"
                      />
                  </div> -->
                  
                </div>
              </div>
              <div style="height: 10%;">
                <div class="row" >
    
                  <div class="col-6 flex flex-center">
                    <q-btn color="grey-8" class="" style="width: 80%; border-radius: 0.5rem;" @click="backButton()" v-if="step == 2" > 
                      <div class="py-1" >
                        Volver
                      </div>
                    </q-btn>
                  </div>
                  <div class="col-6 flex flex-center">
                    <q-btn color="primary" class="" style="width: 80%; border-radius: 0.5rem;" type="submit" :loading="loading">
                      <div class="py-1" >
                        Siguiente
                      </div>
                    </q-btn>
                  </div>
                </div>
              </div>
        
            </div>
        
          
        </div>
      </Transition>
    </q-form>
  </div>
  <div v-else class="flex flex-center py-24 w-full">
    <q-spinner-dots
      color="primary"
      size="7rem"
    />
  </div>
</div>
</template>
<style lang="scss">
.headerSection{
  background: #0282d259;
  font-weight: 500;
  color: #006396;
}
.form__inputsReverse{
  & .q-field__inner {
    box-shadow: 0px 3px 4px 0px #bfbfbf48;
    border-radius: 0.5rem;
    border: 1px solid rgb(223, 223, 223);
    padding: 0px 1rem;
  }
}
.selectAreaItem{
  border-radius: 0.6rem;
  box-shadow: 0px 2px 5px 0px #bfbfbf65;
  border: 1px solid #bfbfbfa3;;
}
@media (max-width: 780px) {
.form__inputsReverse{
  & .q-field__inner {

    padding: 0.1rem 1rem;
  }
}
}

</style>