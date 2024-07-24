<template>

  <div class="container">
    <h2 class="title">Escolha uma opção</h2>

    <div class="row w-100 mb-2">
      <div class="col-lg-3 p-3">
        <div class="mb-4 bg-success menu-painel" @click="modalCadastroCliente()">         
          <i class="fas fa-rss-square"></i>
          <br>
          <span>CADASTRAR CLIENTE</span>
        </div>
      </div>

      <div class="col-lg-3 p-3">
        <div class="mb-4 bg-danger menu-painel" @click="modalFileUpload()">         
          <i class="fas fa-rss-square"></i>
          <br>
          <span>ENVIAR DECLARAÇÃO</span>
        </div>
      </div>

      <div class="col-lg-3 p-3">
        <div class="mb-4 bg-warning menu-painel" @click="modalOptions()">         
          <i class="fas fa-rss-square"></i>
          <br>
          <span>OPÇÕES</span>
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
import UserOptionsModal from '@/components/modal/UserOptionsModal.vue';
import { pushModal, openModal } from 'jenesius-vue-modal';

export default {
  components: {
    CadastrarClienteModal,
    FileUploadModal,
    UserOptionsModal,
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

    modalFileUpload() {
      pushModal(FileUploadModal)
    },

    modalOptions() {
      pushModal(UserOptionsModal)
    },
  }
};
</script>

<style scoped>
  .title{
    margin-top: 25px;
    margin-bottom: 25px;
  }

  .menu-painel {
    align-items: center;
    /* justify-content: center; */
    flex-direction: column;
    display: flex;
    height: 190px;
    border-radius: 5px;
    cursor: pointer;
  }
</style>