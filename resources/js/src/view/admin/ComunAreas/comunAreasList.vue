<script setup>
import { inject, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import iconsApp from '@/assets/icons/index'
import { useComunAreaStore } from '@/services/store/comunArea.store';


const comunAreaStore = useComunAreaStore()

const page = ref(1)
const materialIcons = inject('materialIcons')
const search = ref('')
const filter = ref(0)
const lastPage = ref(1)
const ready = ref(false)
const router = useRouter()

const goTo = (url) => {
  router.push(url)
}

const comunAreas = ref([])

const getComunArea = () => {
  ready.value =  false;

  const data = {
    page: page.value,
    search: search.value,
    filter: filter.value,
  }

  comunAreaStore.getPaginationComunArea(data)
  .then((response) =>{
    if(response.code !== 200) throw response
    comunAreas.value = response.data.data;
    lastPage.value = response.data.last_page;
    setTimeout(() => {
      ready.value =  true;
    }, 1000);
  })
  .catch(() =>{

  })
}

onMounted(() =>{
  getComunArea()
})
</script>

<template>
  <div class="h-full"  style="overflow: auto;">
    <div class="px-4 md:px-0 md:flex  md:justify-end md:w-6/6">
      <q-btn color="primary" unelevated class="w-full mt-5 md:mx-24 createButton " style="border-radius: 0.5rem;" @click="goTo('/admin/comun-area/form/add')">
        <div class="flex items-center py-1" >
          <q-icon name="eva-plus-outline"/>
          <div class="q-pt-xs text-bold pl-1">
            Agregar area común
          </div>
        </div>
      </q-btn>
    </div>
    <div class="mt-5 md:mt-8 px-2 md:mx-24  pb-5"  style="overflow: auto;" v-if="ready">
      <!-- <div class="px-2 pt-6 md:pt-3 mt-4  apartamentContainer relative" style="" > -->

      <div class="px-2 pt-3 mt-4  apartamentContainer relative" style="" v-for="comunArea in comunAreas" :key="comunArea.id">
        <div class="flex items-center w-full pb-3">
          <div class="imgItem__container w">
            <div v-html="iconsApp.comunArea" class="flex flex-center px-0 h-full"/>
          </div>
          <div class="px-2 infoItem">
            <div class=" text-bold  text-black" style="font-weight: bold; font-size: 1.3rem;"> 
             {{comunArea.name}}
            </div>
            <div class="mt-1 ellipsis w-full" style="font-weight: 500; font-size: 0.89rem;">
              Costo por uso: {{ comunArea.price == 0 ? 'Sin reserva' : comunArea.price +'  S/.'}}.
            </div>
            <div class="mt-1" style="font-weight: 500; font-size: 0.89rem;">
              Garantia: {{ comunArea.warranty_price == 0 ? 'Sin garantia' : comunArea.warranty_price + ' S/.'}}
            </div>
            <div class="mt-1" style="font-weight: 500; font-size: 0.89rem;">
             Capacidad: {{ comunArea.capacity }} persona(s)
            </div>

          </div>
        </div>
        <div class="flex w-full justify-end py-1" style="border-top: 1px solid lightgrey;">
          <div>
            <q-btn :icon="materialIcons.outlinedFactCheck" class="mx-1" flat color="yellow-9" round size="0.85rem" >
                <q-tooltip
                  transition-show="flip-right"
                  transition-hide="flip-left"
                  :class="'bg-black text-body2 px-2'"
                >
                  Historial de reservas

                </q-tooltip>   
            </q-btn>
          </div>
          <div>
            <q-btn icon="eva-settings-outline" class="mx-1" flat color="primary" round size="0.85rem"  @click="goTo('/admin/comun-area/form/update/'+comunArea.id)">
              <q-tooltip
                  transition-show="flip-right"
                  transition-hide="flip-left"
                  :class="'bg-black text-body2 px-2'"
                >
                  Editar area común
                </q-tooltip>  
            </q-btn>
          </div>
          <div>
            <q-btn icon="eva-trash-2-outline" class="mx-1" flat color="negative" round size="0.85rem" >
              <q-tooltip
                  transition-show="flip-right"
                  transition-hide="flip-left"
                  :class="'bg-black text-body2 px-2'"
                >
                  Borrar area común
                </q-tooltip>  
            </q-btn>
          </div>
          
        </div>
        <!-- <div class="itemBadge px-8 py-1" :class="{'bg-positive':!apartment.owner, 'bg-negative':apartment.owner}"> -->
        <div class="itemBadge md:px-7 px-4 py-1 bg-positive" >

          Disponible
        </div>
      </div>
      <div class="flex justify-center mt-4">

        <q-pagination
          v-model="page"
          color="primary"
          :max="lastPage"
          :max-pages="4"
          :boundary-numbers="false"
          @update:model-value="getApartment()"
        />
      </div>
    </div>
    <div v-else class="flex flex-center py-24">
       <q-spinner-dots
          color="primary"
          size="7rem"
        />
    </div>
  </div>
</template>
<style lang="scss">
.itemBadge{
  color: white;
  font-size: 0.9rem;
  top: 0;
  right: 0;
  position: absolute;
  border-bottom-left-radius: 0.8rem;
  // transform: rotate(45deg);
}
.imgItem__container{
  width: 4.2rem; 
  height: 4.2rem; 
  border-radius: 0.8rem; 
  background: $primary;
}
.infoItem{
  width: calc(100% - 4.2rem);
}
.apartamentContainer{
  overflow: hidden;
  border-radius: .5rem;
  box-shadow: 0px 2px 6px 0px rgb(199, 199, 199);
}
.createButton{
  width: auto;
}
.tabItem {
  opacity: 0.5;
  cursor: pointer;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: all 0.2s ease-out;
  &:hover{
    background: #279edb!important;
  }
  &.active{
    opacity: 1;
  }
  &.leftItem{
    border-top-left-radius: 0.7rem;
    border-bottom-left-radius: 0.7rem;

  }
  &.rightItem{
    border-top-right-radius: 0.7rem;
    border-bottom-right-radius: 0.7rem;

  }
}
@media (max-width: 780px) {
  .createButton{
    width: 100%;
  }
}

</style>
