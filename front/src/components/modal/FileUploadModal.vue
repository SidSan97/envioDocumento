<template>
    <div>
        <ModalHeader
        :title="'Upload de arquivos'"
        @close="$emit('close')"
        />

      <h1>Upload de Arquivo</h1>
      <form @submit.prevent="uploadFile">
        <input type="file" @change="onFileChange" />
        <button type="submit">Upload</button>
      </form>
      <div v-if="uploadPath">
        <p>Arquivo carregado com sucesso!</p>
        <a :href="`http://localhost/envioDocumento/backend/public/api/storage/${uploadPath}`" target="_blank">Ver arquivo</a>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import ModalHeader from '../ModalHeader.vue';

  export default {
    name: 'FileUploadModal',
    components: {
        ModalHeader
    },
    data() {
      return {
        file: null,
        uploadPath: null,
        error: null
      };
    },
    methods: {
      onFileChange(event) {
        this.file = event.target.files[0];
      },
      async uploadFile() {
        if (!this.file) {
          this.error = 'Por favor, selecione um arquivo';
          return;
        }
  
        let formData = new FormData();
        formData.append('file', this.file);
  
        try {
          const response = await axios.post('http://localhost/envioDocumento/backend/public/api/upload', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
          this.uploadPath = response.data.path;
          this.error = null;
        } catch (err) {
          this.error = 'Erro ao fazer upload do arquivo';
          console.error(err);
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
  