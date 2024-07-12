<template>

  <div class="container">
    <h1>Escolha uma opção</h1>

    <div class="row">
      <div class="col-lg-6 p-3">
        <div class="mb-4 menu-painel" @click="modalCadastroCliente();">         
          <i class="fas fa-rss-square"></i>
          <br>
          <span>CADASTRAR CLIENTE</span>
        </div>
      </div>
    </div>










    <nav>
      <button @click="logout">Logout</button>
    </nav>
  </div>
</template>

<script lang="ts">
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';
import CadastrarClienteModal from '@/components/modal/CadastrarClienteModal.vue';
import { pushModal, openModal } from 'jenesius-vue-modal';

export default {
  components: {
    CadastrarClienteModal,
  },
  data() {
    return {
      
    }
  },
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
  },
  methods: {

    modalCadastroCliente() {
      openModal(CadastrarClienteModal)
    }
  }
};
</script>

<style scoped>

</style>