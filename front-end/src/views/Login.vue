<template>
  <div class="login-page">
    <h1>Login</h1>
    <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
    <LoginForm @loginFailed="handleLoginError" />
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import LoginForm from '@/components/LoginForm.vue';

export default defineComponent({
  name: 'Login',
  components: { LoginForm },
  setup() {
    const errorMessage = ref<string | null>(null);

    const handleLoginError = (error: string) => {
      errorMessage.value = error;
    };

    return { errorMessage, handleLoginError };
  },
});
</script>

<style scoped>
.login-page {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 80vh;
  background-color: #f9f9f9;
  padding: 20px;
}

.error-message {
  color: red;
  margin-bottom: 16px;
  font-weight: bold;
}
</style>
