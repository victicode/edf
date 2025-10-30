<script setup>
import { onMounted, ref } from 'vue'
import { useNotificationsStore } from '@/services/store/notifications.store'
import { useRouter } from 'vue-router'

const notifications = useNotificationsStore()
const router = useRouter()
const loading = ref(false)

const load = async (page = 1) => {
  loading.value = true
  try {
    await notifications.fetch({ page, per_page: 15 })
    await notifications.fetchUnreadCount()
  } finally {
    loading.value = false
  }
}

const openItem = (item) => {
  const url = item?.data?.url || item?.url
  if (url) router.push(url)
}

const markItem = async (item) => {
  if (!item.read_at) {
    await notifications.markAsRead(item.id)
  }
}

const markAll = async () => {
  await notifications.markAllAsRead()
}

onMounted(() => {
  load()
})
</script>

<template>
  <div class="h-full overflow-auto md:px-8 md:mx-28 px-3 pb-6">
    <div class="flex justify-between items-center py-3">
      <div class="text-h6">Notificaciones</div>
      <q-btn color="primary" label="Marcar todas como leídas" dense @click="markAll" :disable="notifications.unreadCount===0"/>
    </div>

    <q-inner-loading :showing="loading" />

    <q-list bordered separator>
      <q-item v-for="item in notifications.items" :key="item.id" clickable @click="openItem(item)">
        <q-item-section avatar>
          <q-icon name="eva-bell-outline" :color="item.read_at ? 'grey' : 'primary'" />
        </q-item-section>
        <q-item-section>
          <q-item-label class="text-weight-bold">{{ item.data?.title || 'Notificación' }}</q-item-label>
          <q-item-label caption>{{ item.data?.message }}</q-item-label>
        </q-item-section>
        <q-item-section side>
          <q-btn flat round dense icon="eva-checkmark-circle-2-outline" @click.stop="markItem(item)" :disable="!!item.read_at" />
        </q-item-section>
      </q-item>
    </q-list>

    <div class="flex justify-end py-4">
      <q-pagination
        v-model="notifications.pagination.current_page"
        :max="Math.ceil(notifications.pagination.total / notifications.pagination.per_page) || 1"
        @update:model-value="(p) => load(p)"
        color="primary"
      />
    </div>
  </div>
  
</template>

<style lang="scss">
</style>


