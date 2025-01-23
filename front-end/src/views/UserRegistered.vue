<template>
  <div>
    <h1 v-if="!loading">Olá, {{ user.name }}! O seu cadastro foi realizado com sucesso!</h1>
    <div v-else class="loading">Carregando...</div>
    <button id="profile" @click="goToProfile">Acessar Perfil</button>
    <button @click="logout">Sair</button>
    <ErrorMessage v-if="errors.message" :message="errors.message" />
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '@/api';
import { useStore } from 'vuex';
import ErrorMessage from '@/components/ErrorMessage.vue';
import { User } from '@/models/User';
import type { Errors } from '@/models/Erorrs.ts';

export default defineComponent({
  name: 'UserRegistered',
  components: { ErrorMessage },
  setup() {
    const user = ref<User>({ name: '', email: '' });
    const errors = ref<Errors>({ message: '' });
    const loading = ref<boolean>(true);
    const store = useStore();
    const router = useRouter();

    onMounted(async () => {
      try {
        const response = await api.getUser();
        user.value = response.data;
      } catch (error: any) {
        if (error.response?.data?.mensagem) {
          errors.value.message = error.response.data.mensagem;
        } else {
          errors.value.message = 'Erro ao carregar os dados do usuário.';
        }
        await router.push('/login');
      } finally {
        loading.value = false;
      }
    });

    const goToProfile = () => {
      router.push('/user');
    };

    const logout = async () => {
      try {
        await api.logout();
        await store.dispatch('logout');
        await router.push('/login');
      } catch (error: any) {
        errors.value.message = 'Erro ao fazer logout. Por favor, tente novamente.';
      }
    };

    return {
      user,
      errors,
      loading,
      goToProfile,
      logout,
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
#profile {
  margin: 20px;
}
.loading {
  font-size: 18px;
  color: #666;
}
</style>