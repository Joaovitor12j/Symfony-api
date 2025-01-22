<template>
  <div>
    <h1>Login</h1>
    <LoginForm />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import LoginForm from '@/components/LoginForm.vue';

export default defineComponent({
  name: 'Login',
  components: {
    LoginForm,
  },
});
</script>
