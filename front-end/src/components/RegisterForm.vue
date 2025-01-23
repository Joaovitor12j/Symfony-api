<template>
  <div class="cadastro-container">
    <form @submit.prevent="register">
      <div class="field">
        <label for="name">Nome:</label>
        <input
            type="text"
            id="name"
            v-model.trim="user.name"
            :class="{ invalid: errors.name }"
        />
        <span v-if="errors.name" class="erro">{{ errors.name }}</span>
      </div>
      <div class="field">
        <label for="email">Email:</label>
        <input
            type="email"
            id="email"
            v-model.trim="user.email"
            :class="{ invalid: errors.email }"
        />
        <span v-if="errors.email" class="erro">{{ errors.email }}</span>
      </div>
      <div class="field">
        <label for="password">Senha:</label>
        <input
            type="password"
            id="password"
            v-model.trim="user.password"
            :class="{ invalid: errors.password }"
        />
        <span v-if="errors.password" class="erro">{{ errors.password }}</span>
      </div>
      <div v-if="errors.message" class="erro">{{ errors.message }}</div>
      <button :disabled="isSubmitting" type="submit">
        {{ isSubmitting ? 'Cadastrando...' : 'Cadastrar' }}
      </button>
    </form>
    <div class="login-link">
      <p>Já é cadastrado? <router-link to="/login">Faça login aqui</router-link></p>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from 'vue';
import api from '@/api';
import type { User } from '@/models/User';
import type { Errors } from '@/models/Erorrs.ts';

export default defineComponent({
  name: 'RegisterForm',
  setup() {
    const user = reactive<User>({
      name: '',
      email: '',
      password: '',
    });

    const errors = reactive<Errors>({
      name: '',
      email: '',
      password: '',
      message: '',
    });

    const isSubmitting = ref(false);

    const register = async () => {
      if (isSubmitting.value) return;
      isSubmitting.value = true;
      clearErrors();

      try {
        validateFormInput();

        if (Object.values(errors).some((error) => error)) {
          isSubmitting.value = false;
          return;
        }

        const response = await api.register(user);
        if (response.status === 201) {
          clearForm();
          window.location.href = '/registered';
        }
      } catch (error: any) {
        if (error.response && error.response.status === 422) {
          errors.message = error.response.data.mensagem;
        } else {
          errors.message = 'Erro ao realizar o cadastro. Tente novamente mais tarde.';
        }
      } finally {
        isSubmitting.value = false;
      }
    };

    const validateFormInput = () => {
      if (!user.name) {
        errors.name = 'O nome é obrigatório.';
      } else if (user.name.length < 3) {
        errors.name = 'O nome deve ter pelo menos 3 caracteres.';
      }

      if (!user.email) {
        errors.email = 'O email é obrigatório.';
      } else if (!emailValidate(user.email)) {
        errors.email = 'Insira um email válido.';
      }

      if (!user.password) {
        errors.password = 'A senha é obrigatória.';
      } else if (user.password.length < 6) {
        errors.password = 'A senha deve ter pelo menos 6 caracteres.';
      }
    };

    const clearErrors = () => {
      Object.keys(errors).forEach((key) => (errors[key] = ''));
    };

    const clearForm = () => {
      user.name = '';
      user.email = '';
      user.password = '';
    };

    const emailValidate = (email: string) => {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
      return regex.test(email);
    };

    return {
      user,
      errors,
      isSubmitting,
      register,
    };
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
  margin-bottom: 20px;
}
.field {
  margin-bottom: 20px;
}
label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}
input {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 4px;
}
input.invalid {
  border-color: red;
}
.erro {
  color: red;
  font-size: 14px;
  margin-top: 5px;
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
button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
button:hover:not(:disabled) {
  background-color: #38a274;
}
.login-link {
  margin-top: 20px;
  text-align: center;
}
</style>
