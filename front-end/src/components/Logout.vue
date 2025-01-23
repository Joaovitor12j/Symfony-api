<template>
  <div class="logout-container">
    <p>{{ isLoading ? 'Fazendo logout...' : 'Redirecionando para o login...' }}</p>
    <div v-if="errors.message" class="erro">{{ errors.message }}</div>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import api from '@/api';
import type { Errors } from '@/models/Erorrs.ts';

export default defineComponent({
  name: 'Logout',
  setup() {
    const store = useStore();
    const errors = ref<Errors>({ message: '' });
    const isLoading = ref(true);

    onMounted(async () => {
      try {
        await api.logout();
        await store.dispatch('logout');
      } catch (error: any) {
        errors.value.message = error.response?.data?.mensagem || 'Erro ao fazer logout. Tente novamente.';
      } finally {
        isLoading.value = false;

        setTimeout(() => {
          window.location.href = '/login';
        }, 1500);
      }
    });

    return {
      errors,
      isLoading,
    };
  },
});
</script>

<style scoped>
.logout-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  font-family: Arial, sans-serif;
  text-align: center;
}
.erro {
  color: red;
  font-size: 14px;
  margin-top: 10px;
}
</style>
