<script setup>
  import { storeToRefs } from 'pinia';
  import { useAuthStore } from '@/services/store/auth.services';
  
  
  const { user } = storeToRefs(useAuthStore())
</script>
<template>
  <div class="h-full w-full">
    <div>

    </div>
  </div>
</template>