<script setup>
import { onMounted, ref, watch} from 'vue';
import { Notify } from 'quasar'
import { useApartmentStore } from '@/services/store/apartment.store';
import { useRouter } from 'vue-router';

  const apartmentStore = useApartmentStore()
  const router = useRouter()
  const loading = ref(false)
  const step = ref(1)
  const formData = ref({
    name:'',
    capacity:'',
    price:0,
    warrantyPrice:0,
    description:'',
    maxTime:1,
    timeFrom:'11:32 PM',
    timeTo:'',

  })


  const createApartment = () => {
    loading.value = true 

    apartmentStore.createApartment(formData.value)
    .then((response) => {
      if(response.code !==200) throw response 
      showNotify('positive', 'Apartamento creado con exito')
      setTimeout(()=>{
        loading.value = false
        router.go(-1)

      },1000)
    })
    .catch((response) =>{
      loading.value = false

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
  })
  
</script>
<template>
<div class="md:px-20 md:mx-16 px-2 h-full" style="overflow: auto; ">
  <div class="text-center text-black text-h5 text-bold md:mt-4 mt-8 md:mb-8 mb-4">
    Datos del area común
  </div>
  <q-form
  @submit="createApartment()"
  >

    <div class=" w-full" >
      <Transition name="horizontal">

        <div class="row w-full" v-if="step==0">
  
          <div class="col-md-6 col-12 mt-1 px-2 md:px-12">
            <div class="text-subtitle2 text-black">
              Nombre del area
            </div>
            <q-input
                dense
                borderless
                clearable
                v-model="formData.name"
                class="form__inputsR mt-1"
                color="primary"
                :rules="[ val => val && val.length > 0 || 'Nombre de area es requerido']"
              />
          </div>
          <div class="col-md-6 col-12 mt-1 px-2 md:px-12">
            <div class="text-subtitle2 text-black">
              Aforo
            </div>
            <q-input
                dense
                borderless
                clearable
                v-model="formData.capacity"
                class="form__inputsR mt-1"
                color="primary"
                :rules="[ val => val && val.length > 0 || 'Nombre de area es requerido']"
              />
          </div>
          <div class="col-md-6 col-12 mt-1 px-2 md:px-12">
            <div class="text-subtitle2 text-black">
              Precio por reserva
            </div>
            <q-input
                dense
                borderless
                clearable
                v-model="formData.price"
                class="form__inputsR mt-1"
                color="primary"
                hint="Dejar en 0 si no requiere reserva"
                :rules="[ val => val && val.length > 0 || 'Nombre de area es requerido']"
              />
          </div>
          <div class="col-md-6 col-12 mt-2 px-2 md:px-12">
            <div class="text-subtitle2 text-black">
              Precio de garantia
            </div>
            <q-input
                dense
                borderless
                clearable
                v-model="formData.warrantyPrice"
                class="form__inputsR mt-1"
                color="primary"
                hint="Dejar en 0 si no aplica garantia"
                :rules="[ val => val && val.length > 0 || 'Nombre de area es requerido']"
              />
          </div>
    
          <div class="col-md-6 col-12 mt-2 px-2 md:px-12">
            <div class="text-subtitle2 text-black">
              Descripción
            </div>
            <q-input
                borderless
                clearable
                v-model="formData.description"
                class="form__inputsR mt-1"
                color="primary"
                :rules="[ val => val && val.length > 0 || 'La ubicación es requerida']"
              />
          </div>
        </div>
      </Transition>

      <Transition name="horizontal">

        <div class="row w-full" v-if="step==1">
  
          <div class="col-md-6 col-12 mt-1 px-2 md:px-12">
            <div class="text-subtitle2 text-black">
              Maximo de horas de reserva
            </div>
            <q-input
                dense
                borderless
                clearable
                v-model="formData.maxTime"
                class="form__inputsR mt-1"
                color="primary"
                :rules="[ val => val && val.length > 0 || 'Nombre de area es requerido']"
              />
          </div>
          <div class="col-md-6 col-12 mt-1 px-2 md:px-12">
            <div class="text-subtitle2 text-black">
              Horas disponibles:
            </div>
            <div class="row w-full mt-2">
              
              <div class="col-6  pr-2">
                <div class="text-body2 text-black">
                  Desde:
                </div>
                <q-input v-model="formData.timeFrom" mask="time" :rules="['time']" dense
                  borderless
                  clearable
                  class="form__inputsR mt-1"
                  color="primary"
                >
                  <template v-slot:append>
                    <q-icon name="eva-clock-outline" class="cursor-pointer">
                      <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                        <q-time v-model="formData.timeFrom">
                          <div class="row items-center justify-end">
                            <q-btn v-close-popup label="Close" color="primary" flat />
                          </div>
                        </q-time>
                      </q-popup-proxy>
                    </q-icon>
                  </template>
                </q-input>

              </div>
              <div class="col-6  pl-2">
                <div class="text-body2 text-black">
                  Hasta:
                </div>
                <q-input v-model="formData.timeTo" mask="time" :rules="['time']" dense
                  borderless
                  clearable
                  class="form__inputsR mt-1"
                  color="primary"
                >
                  <template v-slot:append>
                    <q-icon name="eva-clock-outline" class="cursor-pointer">
                      <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                        <q-time v-model="formData.timeTo">
                          <div class="row items-center justify-end">
                            <q-btn v-close-popup label="Close" color="primary" flat />
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
      </Transition>

      <div class="w-full mb-2 px-2 md:px-12 flex justify-end mt-4">
        <q-btn color="primary " style="border-radius: 0.5rem;" type="submit" :loading="loading">
          <div class="px-10 py-1" >
            Siguiente
          </div>
        </q-btn>
      </div>

    </div>

  </q-form>
</div>
</template>
<style lang="scss">
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