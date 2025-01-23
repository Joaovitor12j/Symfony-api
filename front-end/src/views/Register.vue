<template>
  <div class="register-page">
    <h1>Cadastro</h1>
    <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
    <RegisterForm @registerFailed="handleRegisterError" />
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import RegisterForm from '@/components/RegisterForm.vue';

export default defineComponent({
  name: 'Register',
  components: { RegisterForm },
  setup() {
    const errorMessage = ref<string | null>(null);

    const handleRegisterError = (error: string) => {
      errorMessage.value = error;
    };

    return { errorMessage, handleRegisterError };
  },
});
</script>

<style scoped>
.register-page {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 80vh;
  background-color: #f0f0f0;
}

.error-message {
  color: red;
  margin-bottom: 20px;
  font-weight: bold;
}

p {
  margin-top: 20px;
  color: #555;
}
</style>
