<template>
  <div>
    <h1>Bem-vindo, {{ user.name }}!</h1>
    <button @click="logout">Sair</button>
    <div v-if="errors.message" class="erro">{{ errors.message }}</div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import api from '@/api';
import { User } from '@/models/User';
import type {Errors} from "@/models/Erorrs.ts";

export default defineComponent({
  name: 'UserProfile',
  setup() {
    const user = ref<User>({ name: '', email: ''});
    const errors = ref<Errors>({message: ''});
    const store = useStore();

    onMounted(async () => {
      try {
        const response = await api.getUser();
        user.value = response.data;
      } catch (error: any) {
        if (error.response) {
          errors.value.message = error.response.data.mensagem;
          window.location.href = '/login';
        }
      }
    });

    const logout = async () => {
      try {
        await api.logout();
        await store.dispatch('logout');
        window.location.href = '/login';
      } catch (error: any) {
        errors.value.message = 'Erro ao fazer logout. Por favor, tente novamente.';
      }
    };

    return {
      user,
      errors,
      logout
    };
  },
});
</script>

<style scoped>
.erro {
  color: red;
  font-size: 14px;
  padding-bottom: 10px;
}
button {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #42b983;
  color: white;
  border: none;
  font-size: 16px;
  cursor: pointer;
}
button:hover {
  background-color: #38a274;
}
</style>