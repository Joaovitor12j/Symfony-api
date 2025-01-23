<template>
  <form @submit.prevent="login">
    <div>
      <label for="email">Email:</label>
      <input type="email" v-model="credentials.email" required />
    </div>
    <div>
      <label for="password">Senha:</label>
      <input type="password" v-model="credentials.password" required />
    </div>
    <button type="submit">Entrar</button>
  </form>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import api from '@/api';
import type { User } from '@/models/User';

export default defineComponent({
  name: 'LoginForm',
  data() {
    return {
      credentials: {
        email: '',
        password: ''
      } as User
    };
  },
  methods: {
    async login() {
      try {
        await api.login(this.credentials);
        this.$router.push('/user');
      } catch (error) {
        console.error('Erro ao fazer login:', error);
      }
    },
  },
});
</script>
