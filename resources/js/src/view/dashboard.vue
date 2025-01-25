<script setup>
import { useAuthStore } from '@/services/store/auth.services';
import { storeToRefs } from 'pinia'

const { user } = storeToRefs(useAuthStore());
</script>
<template>
  <div>
    <h1>hola {{user.name}}</h1>
  </div>
</template>