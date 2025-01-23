<template>
  <div class="cadastro-container">
    <form @submit.prevent="register">
      <div class="field">
        <label for="name">Nome:</label>
        <input type="text" id="name" v-model="user.name" />
        <span v-if="errors.name" class="erro">{{ errors.name }}</span>
      </div>
      <div class="field">
        <label for="email">Email:</label>
        <input id="email" v-model="user.email" />
        <span v-if="errors.email" class="erro">{{ errors.email }}</span>
      </div>
      <div class="field">
        <label for="password">Senha:</label>
        <input type="password" id="password" v-model="user.password" />
        <span v-if="errors.password" class="erro">{{ errors.password }}</span>
      </div>
      <div v-if="errors.message" class="erro">{{ errors.message }}</div>
      <button type="submit">Cadastrar</button>
    </form>
    <div class="login-link">
      <p>Já é cadastrado? <router-link to="/login">Faça login aqui</router-link></p>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import api from '@/api';
import type { User } from '@/models/User';
import type {Errors} from "@/models/Erorrs.ts";

export default defineComponent({
  name: 'RegisterForm',
  data() {
    return {
      user: {
        name: '',
        email: '',
        password: ''
      } as User,
      errors: {
        name: '',
        email: '',
        password: '',
        message: ''
      } as Errors
    };
  },
  methods: {
    async register() {
      try {
        this.validateFormInput();
        if (Object.keys(this.errors).length > 0) {
          throw new Error('Dados de cadastros inválidos.');
        }

        const response = await api.register(this.user);
        this.user = {};
        if (response.status === 201) {
          this.$router.push('/registered');
        }
      } catch (error: any) {
        if (error.response && error.response.status === 422) {
          this.errors.message = error.response.data.mensagem;
        }
      }
    },
    validateFormInput() {
      this.errors = {};

      if (!this.user.name) {
        this.errors.name = 'O nome é obrigatório.';
      }

      if (!this.user.email) {
        this.errors.email = 'O email é obrigatório.';
      } else if (!this.emailValidate(this.user.email)) {
        this.errors.email = 'Insira um email válido.';
      }

      if (!this.user.password) {
        this.errors.password = 'A senha é obrigatória.';
      } else if (this.user.password.length < 6) {
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
.cadastro-container {
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
  padding-bottom: 10px;
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
.login-link {
  margin-top: 20px;
  text-align: center;
}
</style>
