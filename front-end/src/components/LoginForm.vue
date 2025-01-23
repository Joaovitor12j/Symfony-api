<template>
  <div class="login-container">
    <form @submit.prevent="login">
      <div class="field">
        <label for="email">Email:</label>
        <input
            type="email"
            id="email"
            v-model.trim="credentials.email"
            :class="{ invalid: errors.email }"
        />
        <span v-if="errors.email" class="erro">{{ errors.email }}</span>
      </div>
      <div class="field">
        <label for="password">Senha:</label>
        <input
            type="password"
            id="password"
            v-model.trim="credentials.password"
            :class="{ invalid: errors.password }"
        />
        <span v-if="errors.password" class="erro">{{ errors.password }}</span>
      </div>
      <div v-if="errors.message" class="erro">{{ errors.message }}</div>
      <button :disabled="isSubmitting" type="submit">
        {{ isSubmitting ? 'Entrando...' : 'Entrar' }}
      </button>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from 'vue';
import api from '@/api';
import type { Credentials } from '@/models/User';
import type { Errors } from '@/models/Erorrs.ts';

export default defineComponent({
  name: 'LoginForm',
  setup() {
    const credentials = reactive<Credentials>({
      email: '',
      password: '',
    });

    const errors = reactive<Errors>({
      email: '',
      password: '',
      message: '',
    });

    const isSubmitting = ref(false);

    const login = async () => {
      if (isSubmitting.value) return;
      isSubmitting.value = true;
      clearErrors();

      try {
        validateFormInput();

        if (Object.values(errors).some((error) => error)) {
          isSubmitting.value = false;
          return;
        }

        const response = await api.login(credentials);
        if (response.status === 200) {
          window.location.href = '/user';
        }
      } catch (error: any) {
        if (error.response) {
          errors.message = error.response.data.mensagem || 'Erro no servidor.';
        } else {
          errors.message = 'Erro ao se conectar com o servidor.';
        }
      } finally {
        isSubmitting.value = false;
      }
    };

    const validateFormInput = () => {
      if (!credentials.email) {
        errors.email = 'O email é obrigatório.';
      } else if (!emailValidate(credentials.email)) {
        errors.email = 'Insira um email válido.';
      }

      if (!credentials.password) {
        errors.password = 'A senha é obrigatória.';
      } else if (credentials.password.length < 6) {
        errors.password = 'A senha deve ter pelo menos 6 caracteres.';
      }
    };

    const clearErrors = () => {
      errors.email = '';
      errors.password = '';
      errors.message = '';
    };

    const emailValidate = (email: string) => {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
      return regex.test(email);
    };

    return {
      credentials,
      errors,
      isSubmitting,
      login,
    };
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
label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}
input {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
}
input.invalid {
  border: 1px solid red;
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
</style>