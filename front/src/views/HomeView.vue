<template>

  <div class="container">
    <h1>Escolha uma opção</h1>

    <div class="row w-100">
      <div class="col-lg-3 p-3 bg-success">
        <div class="mb-4 menu-painel" @click="modalCadastroCliente();">         
          <i class="fas fa-rss-square"></i>
          <br>
          <span>CADASTRAR CLIENTE</span>
        </div>
      </div>

      <div class="col-lg-3 p-3 bg-danger">
        <div class="mb-4 menu-painel" @click="modalCadastroCliente();">         
          <i class="fas fa-rss-square"></i>
          <br>
          <span>ENVIAR DECLARAÇÃO</span>
        </div>
      </div>

      <div class="col-lg-3 p-3 bg-warning">
        <div class="mb-4 menu-painel" @click="modalFileUpload();">         
          <i class="fas fa-rss-square"></i>
          <br>
          <span>SUBIR DECLARAÇÃO</span>
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
import FileUploadModal from '@/components/modal/FileUploadModal.vue';
import { pushModal, openModal } from 'jenesius-vue-modal';

export default {
  components: {
    CadastrarClienteModal,
    FileUploadModal,
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
      pushModal(CadastrarClienteModal)
    },

    modalFileUpload(){
      pushModal(FileUploadModal/*, {idUser: authS}*/)
    },
  }
};
</script>

<style scoped>

</style>