<script setup>
  import { reactive, ref } from 'vue';
  import { useAuthStore } from '@/services/store/auth.services';
  import { useRouter } from 'vue-router'
  import { Notify } from 'quasar'
  import tutorial from '@/components/login/tutorial.vue';
  import storage from '@/services/storage'
  import bg from '@/assets/img/util/bg3.webp'

  const authServices = useAuthStore()
  const tutorialView = ref(storage.getItem('tutorial'))
  const login = reactive({
    username: '',
    password: ''
  })
  
  const isPwd =  ref('true')
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
  const endTutorial = () => {
    tutorialView.value = 'true'
  }
</script>
<template>
  <div class="h-full bg-white" >
    <Transition name="horizontalPage">
      <div class="h-full  md:w-2/3 md:mx-auto login__container" v-if="tutorialView == 'true'" :style=" {backgroundImage:'url('+bg+ ')'}">
        <div style="background: rgb(255 255 255 / 76%);" class="h-full  md:w-full login__container">
          <section class="text-left text-white md:px-8 px-8 h-1/6 flex justify-center column bg-sky-600" style=" border-bottom-left-radius: 3rem; border-bottom-right-radius: 3rem;" >
            <div class="font-bold font-sans  text-3xl">Inicia sesion</div>
            <div class="text-subtitle2 mt-1 md:pl-1 text-gray-300">
              Inicia sesión con tu cuenta
            </div>
          </section>
          <section class="mt-0 md:mt-12 " >
            <q-form
              @submit="authLogin"
              class="w-full h-full"
            >
              <div class="mx-auto form__cont md:px-8" >
                <div class="w-full h-full">
                  <div class="relative md:px-10 px-5 h-full w-full form pt-12 md:pt-0">
                    <div class="font-bold text-3xl text-sky-600 form_welcome">
                      Bienvenido!
                    </div>
                    <div class="w-full mt-10 md:mt-8 ">
                      <q-input  v-model="login.username" :rules="rules('user')" placeholder="Usuario" color="primary" >
                        <template v-slot:prepend>
                          <q-icon name="eva-person-outline" color="sky-600" />
                        </template>
                      </q-input>
      
                      <q-input  v-model="login.password" :rules="rules('password')" placeholder="Contraseña" color="primary" :type="isPwd ? 'password' : 'text'"  class="q-pt-lg">
                        <template v-slot:prepend>
                          <q-icon name="eva-lock-outline"  color="sky-600"/>
                        </template>
                        <template v-slot:append>
                          <q-icon
                            :name="isPwd ? 'eva-eye-off-outline' : 'eva-eye-outline'"
                            class="cursor-pointer"
                            @click="isPwd = !isPwd"
                          />
                        </template>
                      </q-input>
                      <p class="mt-2 text-grey-7 cursor-pointer">¿Olvidaste tu contraseña?</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="md:px-16 px-3 mt-2 flex justify-end ">
                <q-btn flat class="btn__login" :loading="loading" size="lg" type="submit" >
                  <div class="md:hidden blockx text-subtitle1 text-bold px-2 text-white"  >Continuar</div>
                  <q-icon name="eva-arrow-forward-outline" size="lg" class="icon_login_b px-2 " color="white" />
                </q-btn>
              </div>
            </q-form>
          </section>
        </div>
      </div>
    </Transition>
    <Transition name="horizontalPage">
      <div class="h-full" v-if="tutorialView != 'true'">
        <tutorial @end="endTutorial()"/>
      </div>
    </Transition>
  </div>
</template>


<style lang="scss">
.login__container{
  background-size: 100% 50%!important;
  background-position: bottom;
  background-repeat: no-repeat;

}
.btn__login{
  --tw-bg-opacity: 1;
  background-color: rgb(2 132 199 / var(--tw-bg-opacity, 1)); 
  box-shadow: 0px .2rem 1rem 0px rgba(0, 0, 0, 0.345);
  transition: all 0.5s ease;
  border-radius: 80%;
  padding: 0;
  min-width: 2.5em;
  min-height: 2.6em;
  
  & .icon_login_b{
    transition: all 1s ease;
    display: block;
  }
  &:hover{
    --tw-bg-opacity: 1;
    background-color: white; 
    & .icon_login_b{
      color: rgb(2 132 199 / var(--tw-bg-opacity, 1))!important;

    }
  }

}

.form{
  display: flex;
    flex-direction: column;
    justify-content: center;
}
@media (max-width: 780px) {
.btn__login{
  width: 100%;
  border-radius: 1rem;
  & .icon_login_b{
    display: none;
  }
  &:hover{
    --tw-bg-opacity: 1;
    
    color: white; 
    --tw-bg-opacity: 1;
    background-color: rgb(2 132 199 / var(--tw-bg-opacity, 1)); 

  }
}
}
</style>