<template>
  <div>
    <h1>Cadastro</h1>
    <RegisterForm />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import RegisterForm from '@/components/RegisterForm.vue';

export default defineComponent({
  name: 'Register',
  components: {
    RegisterForm,
  },
});
</script>
