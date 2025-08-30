<template>
  <q-tabs
    no-caps
    right-icon="-"
    active-color="terciary"
    align="justify"
    class="bg-white text-dark shadow-0 fixed-bottom bottom-tab q-py-md-xs q-px-md-lg flex q-py-xs userNavbar" 
  >
    <q-route-tab class="q-px-xs-sm q-px-md-lg" :to="'/admin/dashboard'" exact >
      <div class="flex flex-center column">
        <div v-html="wozIcons.home" />
        <span class="q-mt-xs text-dark text-caption">Inicio</span>
      </div>
    </q-route-tab>
    <q-route-tab class="q-px-xs-sm q-px-md-lg" to="/users" exact > 
      <div class="flex flex-center column">
        <div v-html="wozIcons.clients" />
        <span class="q-mt-xs text-dark text-caption">Clientes</span>
      </div>
    </q-route-tab>
    <q-route-tab class="q-px-xs-sm q-px-md-lg" to="/users/loan" exact >
      <div class="flex flex-center column">
        <section class="flex flex-center column relative">
          <div v-html="wozIcons.solicitar" />
          <div v-if="countPending > 0"  rounded floating class="notificationBadge bg-negative"  >
            {{ countPending >= 10 ? '+'+countPending : countPending }}
          </div>
        </section>
        <span class="q-mt-xs text-dark text-caption">Solicitudes</span>
      </div>
    </q-route-tab>
    <q-route-tab class="q-px-xs-sm q-px-md-lg" to="/users/clean" exact >
      <div class="flex flex-center column">
        <div v-html="wozIcons.cleanPayer" />
        <span class="q-mt-xs text-dark text-caption">Cliente al dia</span>
      </div>
    </q-route-tab>
    <q-route-tab class="q-px-xs-sm q-px-md-lg" to="/users/slow_payer" exact >
      <div class="flex flex-center column">
        <div v-html="wozIcons.slowPayer" />
        <span class="q-mt-xs text-dark text-caption">Cliente Mora</span>
      </div>
    </q-route-tab>
  </q-tabs>
</template>

<script>
import { inject, onMounted, ref } from 'vue'
import mainIcons from '@/assets/icons/index'


export default {
  setup () {
    const icons = inject('ionIcons')
    // const loanStore = useLoanStore();
    // const countPending = ref(0)
    // const getSolicitudesCount = () => {
    //   loanStore.getPendingLoan()
    //   .then((response) => {
    //     console.log(response)
    //     // countPending.value = 
    //     countPending.value = response.data
    //   })
    // }
    onMounted(() => {
      getSolicitudesCount()
    })
    return { icons, mainIcons, }
  },
}
</script>
<style lang="scss">
.userNavbar{

  padding-top: 0px!important;
  & .q-tab__indicator {
    bottom: 95%!important;
    height: 5px!important;
  }
  & .q-tab--active {
    & span {
      color:#ffc701!important;
    }
    & path {
      stroke: #ffc701;
    }
  }
}
.q-tab__label{
    font-size: 0.72rem!important;
  }
</style>
<style lang="scss" scoped>
  
  .w-100{
    width: 100%!important;
  }
  .bottom-tab{
    border-top: 1.5px solid $grey-4;
    width: 50%;
    left: 25%;
    height: 9%;
    z-index: 2000;
  }
  @media screen and (max-width: 780px){
    .bottom-tab{
      width: 100%;
      left: 0%;
    }
  }
</style>