<template>
  <form @submit.prevent="register">
    <div>
      <label for="name">Nome:</label>
      <input type="text" v-model="user.name" required />
    </div>
    <div>
      <label for="email">Email:</label>
      <input type="email" v-model="user.email" required />
    </div>
    <div>
      <label for="password">Senha:</label>
      <input type="password" v-model="user.password" required />
    </div>
    <button type="submit">Registrar</button>
  </form>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import api from '@/api';
import type { User } from '@/models/User';

export default defineComponent({
  name: 'RegisterForm',
  data() {
    return {
      user: {
        name: '',
        email: '',
        password: ''
      } as User
    };
  },
  methods: {
    async register() {
      try {
        const response = await api.register(this.user);
      } catch (error) {
        console.error('Erro ao registrar:', error);
      }
    },
  },
});
</script>
