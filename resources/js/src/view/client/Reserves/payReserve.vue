<script setup>
import { ref } from 'vue';
import transfer from '@/assets/img/util/transfer.webp'
import yape from '@/assets/img/util/yape.webp'
import cash from '@/assets/img/util/cash.webp'

import pp from '@/assets/img/util/pp.webp'

const step = ref(1)
const payMethods = [
  {
    title: 'Transferencia Bancaria',
    img:transfer
  },
  {
    title: 'Paypal',
    img:pp
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
const selectedPayMethod = ref('')
</script>
<template>
  <div class="h-full">
    <div class="px-4 mt-8" style="height: 90%;">
      <Transition name="horizontal">
        <div class="h-full "  v-if="step == 1">
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
              <q-radio v-model="selectedPayMethod" :val="key"  />
            </div>
          </div>
        </div>
      </Transition>
      <Transition name="horizontal">
        <div class="h-full " style="" v-if="step == 2">
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
              <q-radio v-model="selectedPayMethod" :val="key" color="green" />
            </div>
          </div>
        </div>
      </Transition>
    </div>
    <div style="height: 10%;">

    </div>
  </div>
</template>
<style lang="scss">
.payMethodItem{
  border-radius: 0.6rem;
  box-shadow: 0px 2px 6px 0px rgb(199, 199, 199);
  border:1px solid rgb(199, 199, 199);
  transition: all 0.5s ease-in-out;
  color:black;
  &:hover{
    transform: scale(1.03);
    background: rgba(20, 61, 107, 0.966);
    color: white;
    border:1px solid rgba(20, 61, 107, 0.966);

    box-shadow: 0px 2px 6px 0px rgba(20, 61, 107, 0.966);

  }
}
</style>