<script setup>
  import { reactive, ref } from 'vue';
  import { useAuthStore } from '@/services/store/auth.services';
  import { useRouter } from 'vue-router'
  import { Notify } from 'quasar'
  const authServices = useAuthStore()
  const login = reactive({
    username: '',
    password: ''
  })
  
  const isPwd =  ref(true)
  const loading = ref(false)
  const router = useRouter();

  const rules = (id) => {
    if(id=='user') return [ 
      val => val && val.length > 0 || 'Usuario no puede quedar vacio',
      val => (/[,$}#*. %"'()\-;&|<>]/.test(val) == false ) || 'No debe contener "[](),%|&;\'" ',
    ]
    if(id=='password') return [ 
      val => val && val.length > 0 || 'Contraseña no puede quedar vacio',
      val => val.length >= 8  || 'Debe tener 8 caracteres minimo'
    ]

  }
  const showNotify = (type,text) => {
    Notify.create({
      color:type,
      message: text,
      position:'top',
      timeout:2000
    })
  }
  const authLogin = () => {
    loading.value = true
    authServices.login(login)
    .then((response) => {
      if(response.status !==200){
        throw response
      }
      showNotify('positive', 'Inicio de sesión correcto')
      setTimeout(() => {
        loading.value = false
        router.push('/dashboard')
      },2000)
    })
    .catch((response) =>{
      showNotify('negative', response.status == 505 ? response.data.error : 'Error de conexión')
      loading.value = false

    })
  }
</script>
<template>
  <div>
    <section class="text-center text-white pt-11 ">
      <div class="font-bold font-sans mt-2 text-4xl">Inicia sesion</div>
    </section>
    <section class="mt-20 mt-md-12 " >
      <q-form
        @submit="authLogin"
        class="w-full h-full"
      >
        <div class="mx-auto form__cont" >
          <div class="w-full h-full">
            <div class="relative px-10 h-full w-full form pt-12 md:pt-0">
              <div class="font-bold text-3xl  form_welcome">
                Bienvenido!
              </div>
              <div class="w-full mt-10 md:mt-5">
                <q-input v-model="login.username" :rules="rules('user')" placeholder="Usuario" color="primary" >
                  <template v-slot:prepend>
                    <q-icon name="eva-person-outline" color="primary" />
                  </template>
                </q-input>

                <q-input v-model="login.password" :rules="rules('password')" placeholder="Contraseña" color="primary" :type="isPwd ? 'password' : 'text'"  class="q-pt-lg">
                  <template v-slot:prepend>
                    <q-icon name="eva-lock-outline"  color="primary"/>
                  </template>
                  <template v-slot:append>
                    <q-icon
                      :name="isPwd ? 'eva-eye-off-outline' : 'eva-eye-outline'"
                      class="cursor-pointer"
                      @click="isPwd = !isPwd"
                    />
                  </template>
                </q-input>
                <p class="mt-2 text-grey-7 cursor-pointer">Olvidaste tu contraseña?</p>
              </div>
            </div>
          </div>
        </div>
        <div class="px-2  mx-auto md:w-2/3 ">
          <q-btn flat round color="white" :loading="loading" size="xl" type="submit" >
            <q-icon name="eva-arrow-forward-outline" size="xl" class="" />
          </q-btn>
        </div>
      </q-form>
    </section>
  </div>
</template>


<style lang="scss">
.form_welcome{
  background: -webkit-linear-gradient(90deg, rgba(0,29,255,1) 0%, rgba(48,30,201,1) 30%, rgba(74,9,121,1) 86%);
  background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-top: -3rem;
}
.form__cont {
  z-index: 2;
  width: 60%;
  position: relative;
  height: 430px;
  display: flex;

  &:before {
    position: absolute;
    display: block;
    width: 100%;
    border-radius: 12px;
    top: 2%;
    height: 100%;
    content: '';
    background: white;
    transform: skewY(18deg);
    z-index: 0;
  }
}
.form{
  display: flex;
    flex-direction: column;
    justify-content: center;
}
@media (max-width: 780px) {
  .form_welcome{
    margin-top: 0rem;
  }
  .form__cont {

    width: 90%;
    height: 450px;


    &:before {
      top: 3rem;
      transform: skewX(0deg) skewY(25deg);
    }
  }
}
</style>