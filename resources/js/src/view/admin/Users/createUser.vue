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
  const isPwd =  ref('true')

  const step = ref(1)
  const loading = ref(false)
  const formData = ref({
    name:'',
    username:'',
    email:'',
    password:'',
  })

  const titleOfSection = [ 
    'Datos de propietario',
    'Asignación del inmobiliario'
  ]
  const createUser = () => {
    loading.value = true 

    step.value++
    setTimeout(() => {
      alert('holaaaa')
      loading.value = false

    }, 2000);
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
<div class="md:px-20 md:mx-16 px-2">
  <div class="text-center text-black text-h5 text-bold md:mt-4 mt-8 mb-8">
    {{ titleOfSection[step]}}
  </div>
  <q-form
  @submit="createUser()"
  >
    <Transition name="horizontal">
      <div class="row w-full" v-if="step==0">
        <div class="col-md-6 col-12 my-0 px-2 md:px-12">
          <div class="text-subtitle2 text-bold text-black">
            Nombre completo
          </div>
          <q-input
              borderless
              clearable
              v-model="formData.name"
              class="form__inputsR mt-2"
              color="primary"
              :rules="[ val => val && val.length > 0 || 'Nombre es requerido']"
            />
        </div>
        <div class="col-md-6 col-12 my-0 px-2 md:px-12">
          <div class="text-subtitle2 text-bold text-black">
            Nombre de usuario
          </div>
          <q-input
              borderless
              clearable
              v-model="formData.username"
              class="form__inputsR mt-2"
              color="primary"
              :rules="[ val => val && val.length > 0 || 'Contraseña es requerida']"
            />
        </div>
        <div class="col-md-6 col-12 my-0 px-2 md:px-12">
          <div class="text-subtitle2 text-bold text-black">
            Correo electronico
          </div>
          <q-input
              borderless
              clearable
              v-model="formData.email"
              class="form__inputsR mt-2"
              color="primary"
              :rules="[ val => val && val.length > 0 || 'Correo electronico es requerido']"
            />
        </div>
        <div class="col-md-6 col-12 my-0 px-2 md:px-12">
          <div class="text-subtitle2 text-bold text-black">
            Contraseña
          </div>
          <q-input
              borderless
              clearable
              v-model="formData.password"
              class="form__inputsR mt-2"
              color="primary"
              :type="isPwd ? 'password' : 'text'" 
              :rules="[ val => val && val.length > 0 || 'Nombre de usuario es requerido']"
            >
              <template v-slot:append>
                <q-icon
                  :name="isPwd ? 'eva-eye-off-outline' : 'eva-eye-outline'"
                  class="cursor-pointer"
                  @click="isPwd = !isPwd"
                />
              </template>
            </q-input>
          
        </div>
        <div class="col-12 my-2 px-2 md:px-12 flex justify-end">
          <q-btn color="primary " style="border-radius: 0.5rem;" type="submit" :loading="loading">
            <div class="px-10 py-1" >
              Siguiente
            </div>
          </q-btn>
        </div>

      </div>
    </Transition>
    <Transition name="horizontal">
      <div class="row w-full" v-if="step==1">
        <div class="col-md-6 col-12 md:my-0 mb-1 px-2 md:px-12">
          <div class="text-subtitle2 text-bold text-black">
            Nombre completo
          </div>
          <q-input
              borderless
              clearable
              v-model="formData.name"
              class="form__inputsR mt-2"
              color="primary"
              :rules="[ val => val && val.length > 0 || 'Nombre es requerido']"
            />
        </div>
        <div class="col-md-6 col-12 my-0 px-2 md:px-12">
          <div class="text-subtitle2 text-bold text-black">
            Nombre de usuario
          </div>
          <q-input
              borderless
              clearable
              v-model="formData.username"
              class="form__inputsR mt-2"
              color="primary"
              :rules="[ val => val && val.length > 0 || 'Nombre de usuario es requerido']"
            />
        </div>
        <div class="col-md-6 col-12 my-0 px-2 md:px-12">
          <div class="text-subtitle2 text-bold text-black">
            Correo electronico
          </div>
          <q-input
              borderless
              clearable
              v-model="formData.email"
              class="form__inputsR mt-2"
              color="primary"
              :rules="[ val => val && val.length > 0 || 'Correo electronico es requerido']"
            />
        </div>
        <div class="col-md-6 col-12 my-0 px-2 md:px-12">
          <div class="text-subtitle2 text-bold text-black">
            Contraseña
          </div>
          <q-input
              borderless
              clearable
              v-model="formData.password"
              class="form__inputsR mt-2"
              color="primary"
              type="password"
              :rules="[ val => val && val.length > 0 || 'Contraseña es requerida']"
            />
        </div>
        <div class="col-12 my-0 px-2 md:px-12 flex justify-end">
          <q-btn color="primary " style="border-radius: 0.5rem;" type="submit" :loading="loading">
            <div class="px-10 py-1" >
              Siguiente
            </div>
          </q-btn>
        </div>

      </div>
    </Transition>
  </q-form>
</div>
</template>
<style lang="scss">
.form__inputsR{
  & .q-field__inner {
    box-shadow: 0px 3px 5px 0px #bfbfbfa3;
    border-radius: 0.8rem;
    border: 1px solid rgb(223, 223, 223);
    padding: 0px 2rem;
  }
}
@media (max-width: 780px) {
.form__inputsR{
  & .q-field__inner {

    padding: 0px 1rem;
  }
}
}

</style>