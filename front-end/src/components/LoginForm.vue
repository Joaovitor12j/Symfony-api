<template>
  <div class="login-container">
    <form @submit.prevent="login">
      <div class="field">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="credentials.email" />
        <span v-if="errors.email" class="erro">{{ errors.email }}</span>
      </div>
      <div class="field">
        <label for="password">Senha:</label>
        <input type="password" id="password" v-model="credentials.password" />
        <span v-if="errors.password" class="erro">{{ errors.password }}</span>
      </div>
      <div v-if="errors.message" class="erro">{{ errors.message }}</div>
      <button type="submit">Entrar</button>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import api from '@/api';
import type { User } from '@/models/User';
import type {Errors} from "@/models/Erorrs.ts";

export default defineComponent({
  name: 'LoginForm',
  data() {
    return {
      credentials: {
        email: '',
        password: ''
      } as User,
      errors: {
        email: '',
        password: '',
        message: ''
      } as Errors,
    };
  },
  methods: {
    async login() {
      try {
        this.validateFormInput();

        if (Object.keys(this.errors).length > 0) {
          throw new Error('Dados de cadastros inválidos.');
        }

        const response = await api.login(this.credentials);
        if (response.status === 200) {
          this.$router.push('/user');
        }
      } catch (error: any) {
        if (error.response && error.response.status === 401) {
          this.errors.message = error.response.data.mensagem;
        }
      }
    },
    validateFormInput() {
      this.errors = {};

      if (!this.credentials.email) {
        this.errors.email = 'O email é obrigatório.';
      } else if (!this.emailValidate(this.credentials.email)) {
        this.errors.email = 'Insira um email válido.';
      }

      if (!this.credentials.password) {
        this.errors.password = 'A senha é obrigatória.';
      } else if (this.credentials.password.length < 6) {
        this.errors.password = 'A senha deve ter pelo menos 6 caracteres.';
      }

      return this.errors;
    },
    emailValidate(email: string) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
      return regex.test(email);
    }
  },
});
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: 50px auto;
  font-family: Arial, sans-serif;
}
h1 {
  text-align: center;
}
.field {
  margin-bottom: 20px;
}
.label, label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}
input {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
}
.erro {
  color: red;
  font-size: 14px;
}
button {
  width: 100%;
  padding: 10px;
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