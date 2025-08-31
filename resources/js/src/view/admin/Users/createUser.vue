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
<div>

</div>
</template>
<style lang="scss">

</style>