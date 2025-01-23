<template>
  <div>
    <h1>Olá, {{ user.name }}! O seu cadastro foi realizado com sucesso!</h1>
  </div>
  <div v-if="errors.message" class="erro">{{ errors.message }}</div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import api from '@/api';
import { User } from '@/models/User';
import type {Errors} from "@/models/Erorrs.ts";

export default defineComponent({
  name: 'UserRegistered',
  setup() {
    const user = ref<User>({ name: '', email: ''});
    const errors = ref<Errors>({message: ''});

    onMounted(async () => {
      try {
        const response = await api.getUser();
        user.value = response.data;
      } catch (error: any) {
        if (error.response) {
          errors.message = error.response.data.mensagem;
          window.location.href = '/login';
        }
      }
    });

    return {
      user,
      errors,
    };
  },
});
</script>

<style scoped>
.erro {
  color: red;
  font-size: 14px;
  padding-bottom: 10px;
}
</style>