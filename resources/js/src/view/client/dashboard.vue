<script setup>
  import { storeToRefs } from 'pinia';
  import { useAuthStore } from '@/services/store/auth.services';
  const { user } = storeToRefs(useAuthStore())
</script>
<template>
  
  <div>
    Hola {{ user }}
  </div>
</template>