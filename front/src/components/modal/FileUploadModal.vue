<template>
  <div>
    <ModalHeader
    :title="'Upload de arquivos'"
    @close="$emit('close')"
    />

    <h1>Upload de Arquivo</h1>

    <form @submit.prevent="uploadFile">
      <input type="file" @change="onFileChange" multiple />
      <button type="submit">Upload</button>
    </form>

    <div v-if="message" class="alert alert-success" role="alert">
      <p>{{ message }}</p>

      <p v-if="errorMultimidia">
        OBSERVAÇÕES: <br>
        <span v-for="(item, key) in errorMultimidia.erro" :key="key">
          {{ item }} <br>
        </span>
      </p>
    </div>

    <div v-if="error" class="alert alert-danger" role="alert">
      {{ error }}
    </div>
  </div>
</template>
  
<script>
  import axios from 'axios';
  import ModalHeader from '../ModalHeader.vue';
  import { useAuthStore } from '../../stores/auth';

  export default {
    name: 'FileUploadModal',
    components: {
        ModalHeader
    },
    data() {
      return {
        files: [],
        uploadPath: null,
        error: null,
        message: null,
        errorMultimidia: null
      };
    },
    setup() {
      const authStore = useAuthStore();
      
      return {
        user: 
          authStore.user,
          logout: authStore.logout
      };
    },
    methods: {
      onFileChange(event) {
        this.files = Array.from(event.target.files);
      },
      async uploadFile() {
        if (!this.files.length === 0) {
          this.error = 'Por favor, selecione um arquivo';
          return;
        }
  
        let formData = new FormData();
        this.files.forEach(file => {
          formData.append('files[]', file);
        });
        formData.append('id', this.user.id);
  
        this.$loading.show()
        try {
          const response = await axios.post('http://localhost/envioDocumento/backend/public/api/enviar-documento', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
         
          if(response.status == 207){
            this.errorMultimidia = response.data.erros;
          }

          this.message    = response.data.message;
          this.error      = null;

        } catch (err) {
          this.message = null;
          this.error   = err.response.data.error;
          console.error(err);

        }finally {
          this.$loading.hide();
        }
      }
    }
  };
</script>

<style scoped>
    .modal-item {
        background-color: #fefefe !important;
    }
</style>
  