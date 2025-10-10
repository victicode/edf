<script setup>
import { Notify } from 'quasar'
import { ref, watch } from 'vue';
import { useAuthStore } from '@/services/store/auth.services';
import { useRouter } from 'vue-router';

// import { useClientStore } from '@/services/store/client.store';
const emit = defineEmits(['closeModal'])
const authStore = useAuthStore()
const props = defineProps({
  dialog: Boolean,
})
const router = useRouter()
const loading = ref(false)
const dialog = ref(props.dialog)
const hideModal = () => {
  emit('closeModal')
}

watch(() => props.dialog, (newValue) => {
  dialog.value = newValue
});

const logout = () => {
  loading.value = true
  authStore.logout()
    .then((response) => {
      loading.value = false
      router.push('/login')
    })
    .catch(() => {
      loading.value = false

    })
  // console.log('sssss')
}

</script>
<template>
  <q-dialog v-model="dialog" class="createPayMethodDialog" persistent backdrop-filter="blur(0.5px)">
    <q-card class="dialog_document public " style="border-radius:1rem">
      <div>
        <q-card-section class="q-px-none">
          <div class="text-h6 text-center text-black pb-2" style="border-bottom: 1px solid lightgray;">
            Cierre de sesión
          </div>
        </q-card-section>
        <section class="content__modalSectionRifa md:mt-5 mt-0 ">
          <q-card-section class="q-pt-none q-px-sm ">
            <div class="px-2">
              <div class="text-h6 text-center text-black">
                ¿Seguro que deseas  cerrar la sesión?
              </div>
            </div>
          </q-card-section>
        </section>
      </div>
      <section class="pb-5">
        <div class="flex justify-evenly mt-5">
          <q-btn label="No" unelevated class="q-mx-sm " color="primary" outline
            style="border-radius: 0.8rem; padding:0px  2rem!important; font-size: 1rem;  " @click="hideModal()" />
          <q-btn label="Si" unelevated class="q-mx-sm " color="primary" outline
            style="border-radius: 0.8rem; padding:0px  2rem!important; font-size: 1rem;  " :loading="loading"
            @click="logout()" />
        </div>
      </section>

    </q-card>
  </q-dialog>
</template>
<style lang="scss">
.statusInput.q-field--auto-height.q-field--labeled .q-field__control-container {
  padding-top: 10px;
}

.createPayMethodDialog {
  margin-left: 0%;
  overflow: hidden;
  overflow: visible !important;
  position: relative;

  & .dialog_document {

    max-width: 90%;
    border-radius: 1rem !important;
    // height: 100%;
    width: 30%;

  }

  & .q-dialog__inner--minimized {
    padding: 0px;
  }
}

.order__form {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.content__modalSectionRifa {
  overflow: auto;
  max-height: max-content;

}

.q-item__label {

  color: black !important;
}

.q-item--active {
  & .q-item__label {

    color: goldenrod !important;
  }
}
@media screen and (max-width: 820px) {
  .dialog_document {
    width: 100%;
  }
}
</style>