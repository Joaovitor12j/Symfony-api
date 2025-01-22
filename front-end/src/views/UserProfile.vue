<template>
  <div>
    <h1>Bem-vindo, {{ user.name }}!</h1>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import api from '@/api';

export default defineComponent({
  name: 'UserProfile',
  setup() {
    const user = ref({ name: '', email: '' });

    onMounted(async () => {
      try {
        const response = await api.getUser();
        user.value = response.data;
      } catch (error) {
        console.error('Erro ao obter dados do usuário:', error);
      }
    });

    return {
      user,
    };
  },
});
</script>
