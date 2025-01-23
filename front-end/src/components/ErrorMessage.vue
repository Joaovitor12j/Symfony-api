<template>
  <div class="error-message">
    <p>{{ message }}</p>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'ErrorMessage',
  props: {
    message: {
      type: String,
      required: true,
    },
  },
});
</script>

<style scoped>
.error-message {
  color: red;
  font-size: 14px;
  margin-top: 10px;
}
</style>
