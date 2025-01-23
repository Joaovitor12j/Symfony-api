<template>
  <div class="logout-container">
    <p>Fazendo logout...</p>
  </div>
  <div v-if="errors.message" class="erro">{{ errors.message }}</div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from 'vue';
import { useStore } from 'vuex';
import api from '@/api';
import type {Errors} from "@/models/Erorrs.ts";

export default defineComponent({
  name: 'Logout',
  setup() {
    const store = useStore();
    const errors = ref<Errors>({message: ''});

    onMounted(async () => {
      try {
        await api.logout();
        await store.dispatch('logout');

        setTimeout(() => {
          window.location.href = '/login';
        }, 1500);

      } catch (error: any) {
        if (error.response) {
          errors.message = error.response.data.mensagem;
        }
      }
    });

    return {
      errors,
    };
  },
});
</script>

<style scoped>
.logout-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  font-family: Arial, sans-serif;
}
.erro {
  color: red;
  font-size: 14px;
  padding-bottom: 10px;
}
</style>
