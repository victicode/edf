<script setup>
import { ref, inject, onMounted } from 'vue';
import transfer from '@/assets/img/util/transfer.webp'
import yape from '@/assets/img/util/yape.webp'
import cash from '@/assets/img/util/cash.webp'
import pp from '@/assets/img/util/pp.webp'
import { useRoute, useRouter } from 'vue-router';
import { useReserveStore } from '@/services/store/reserve.store'

const route = useRoute()
const router = useRouter()
const reserveStore = useReserveStore()
const ready = ref(false)
const step = ref(2)
const loading = ref(false)
const disable =  ref(true)
const materialIcons = inject('materialIcons')
const reserve = ref({})
const dataPayForm = ref({
  pay_method:0,
  amount:'',
  vaucher:'',
  reference:'',
  booking_id: route.params.id || route.query.id,
  pay_id:''
})

const payMethods = [
  {
    title: 'Transferencia Bancaria',
    img:transfer
  },
  {
    title: 'Yape',
    img:yape
  },
  {
    title: 'Pago en efectivo',
    img: cash
  }
]

const payData = [
  [
    {
      title:'N° de cuenta',
      value:'0000000000000'
    },
    {
      title:'Banco',
      value:'BCP'
    },
    {
      title:'Titular de la cuenta',
      value:'Juan Perez'
    },
  ],
  [
    {
      title:'N° de télefono',
      value:'997 245 369'
    },
    {
      title:'Titular de la cuenta',
      value:'Juan Perez'
    },
    {
      title:'QR',
      value:'https://upload.wikimedia.org/wikipedia/commons/d/d7/Commons_QR_code.png'
    },
  ],
  [
    {
      title:'Dirección de entrega',
      value:'Lobby edificio central, Horario de 8:00 - 15:00'
    },
  ],

]

const nextStep = () => {
  step.value++
}
const stepBack = () => {
  if(step.value ==1){
    router.go(-1)
    return
  } 
  step.value--
}
const getBookingById = () => {
  reserveStore.getReserveById(route.params.id || route.query.id)
  .then((response) => {
    reserve.value = response.data
    ready.value = true

  })
  .catch((response) => {
    console.log(response)
    ready.value = true
  })
}

const activeClass = (event) => {

  try{
    document.querySelector('.payMethodItem.active').classList.remove('active')
  }catch{
  }
  disable.value = false
  event.target.closest('.payMethodItem').classList.add('active')
}
onMounted(() => {
  getBookingById()
})
</script>
<template>
  <div class="h-full md:px-28" >
    <q-form @submit="nextStep()" class="h-full ">
      <template v-if="ready">
        <section  class=" pt-2 px-3 flex justify-between items-center bg-primary header__container "
          style=" border-bottom-left-radius: 2rem; border-bottom-right-radius: 2rem; height: 10%; position: relative; z-index: 2;">
            <div class="flex items-center">
              <div class="flex items-center">
                <q-btn :icon="materialIcons.outlinedArrowBack" unelevated color="white" flat size="1rem" round
                  @click="stepBack()" />
              </div>
              <div class="text-h6 text-bold text-white ml-2">
                {{ route.meta.pagTitle}}
              </div>
            </div>
        </section>
        <div class="px-4 " style="height: 68%;">
          <Transition name="horizontal">
            <div class="h-full "  v-if="step == 1">
              <div class="text-h6 text-bold text-black py-5">
                ¿Cómo vas a pagar?
              </div>
              <div v-for="(method, key) in payMethods" :key="key" class="payMethodItem mb-5 py-2 px-3 flex justify-between items-center">
                <div class="flex items center">
                  <div class="bg-white" style="border-radius: 0.5rem;">
                    <img :src="method.img" alt="" class="" style="width: 2rem; border-radius: 0.5rem; ">
                  </div>
                  <div class="text-subtitle1  ml-2">
                    {{ method.title }}
                  </div>
                </div>
                <div>
                  <q-radio v-model="dataPayForm.pay_method" :val="key"  @click="activeClass($event)"   />
                </div>
              </div>
            </div>
          </Transition>
          <Transition name="horizontal">
            <div class="h-full " style="" v-if="step == 2">
              <div v-if="dataPayForm.pay_method!==2">
                <div class="dataPayCard pt-5 pb-3 px-3" style="transform: translateY(-0.4rem);">
                  <div class="pb-7 text-h6 text-bold text-black"> 
                    Paga tu reserva
                    <div class=" text-grey-7 mt-1" style="font-size: 0.85rem;line-height: 1.3;">
                      Asegúrate de pagar correctamente, utiliza los datos que te aparcen aca
                    </div>
                  </div>
                  <div v-for="(data, key) in payData[dataPayForm.pay_method]" :key="key" class=" mb-4" >
                    <div class="text-body2 mb-1 text-grey-7">{{ data.title }}</div>
                    <img :src="data.value" alt="" v-if="data.title == 'QR'" class="mx-auto">
                    <div v-else style="font-size: 1.05rem;" class="text-black text-bold ">{{ data.value }}</div>
                  </div>
                </div>
              </div>
              <div v-else>
                
              </div>
            </div>
          </Transition>
          <Transition name="horizontal">
            <div class="h-full " style="" v-if="step == 3">
              <div>
                <div class="dataPayCard pt-5 pb-3 px-3" style="transform: translateY(-0.4rem);">
                  <div class="pb-7 text-h6 text-bold text-black"> 
                    Paga tu reserva
                    <div class=" text-grey-7 mt-1" style="font-size: 0.85rem;line-height: 1.3;">
                      Asegúrate de pagar correctamente, utiliza los datos que te aparcen aca
                    </div>
                  </div>
                  <div v-for="(data, key) in payData[dataPayForm.pay_method]" :key="key" class=" mb-4" >
                    <div class="text-body2 mb-1 text-grey-7">{{ data.title }}</div>
                    <img :src="data.value" alt="" v-if="data.title == 'QR'" class="mx-auto">
                    <div v-else style="font-size: 1.05rem;" class="text-black text-bold ">{{ data.value }}</div>
                  </div>
                </div>
              </div>
            </div>
          </Transition>
        </div>
        <div style="height: 22%; border-top-left-radius: 1rem; border-top-right-radius: 1rem; box-shadow: 0px 0.2rem 1rem 0px rgb(155 155 155 / 53%);" class=" bg-white py-3">
          <div class="mb-3 md:px-16 px-5">
            <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid lightgrey;">
              <div class="text-subtitle2 text-grey-8">Reserva</div>
              <div class="text-subtitle1 text-bold text-black">{{ reserve.comun_area.name }}</div>
            </div>
            <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid lightgrey;">
              <div class="text-subtitle2 text-grey-8">Total</div>
              <div class="text-subtitle1 text-bold text-black">S/. {{ reserve.amount }}</div>
            </div>
          </div>
          <div class="flex flex-center w-full">
            <q-btn color="primary" class="" style="width: 90%; border-radius: 0.5rem;" type="submit"
              :loading="loading" :disable="disable">
              <div class="py-1 md:py-2">
                {{ step == 3 ? 'Guardar reserva' : 'Siguiente' }}
              </div>
            </q-btn>
          </div>
        </div>
      </template>
      <div v-else class="flex flex-center  h-full">
        <q-spinner-dots color="primary" size="7rem" />
      </div>

    </q-form>
  </div>
</template>
<style lang="scss">
.dataPayCard{
    background: white;
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
}
.payMethodItem{
  border-radius: 0.6rem;
  box-shadow: 0px 2px 6px 0px rgb(199, 199, 199);
  border:1px solid rgb(199, 199, 199);
  transition: all 0.5s ease-in-out;
  color:black;
  &.active{
    background: rgba(17, 104, 204, 0.925);
    color: white;
    border:1px solid rgba(17, 104, 204, 0.651);
    box-shadow: 0px 2px 6px 0px rgba(20, 61, 107, 0.966);
  }
  &:hover{
    transform: scale(1.01);
    background: rgba(17, 104, 204, 0.925);
    color: white;
    border:1px solid rgba(17, 104, 204, 0.651);

    box-shadow: 0px 2px 6px 0px rgba(20, 61, 107, 0.966);

  }
}
</style>