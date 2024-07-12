<template>
  <div>
    <h1>Página home</h1>
    <nav>
      <button @click="logout">Logout</button>
    </nav>
  </div>
</template>

<script lang="ts">
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

export default {
    setup() {
        const authStore = useAuthStore();
        const router = useRouter();

        const logout = async () => {
          await authStore.logout();
          router.push('/login');
        };

        return {
          logout
        };
    }
};
</script>

<style scoped>

</style>