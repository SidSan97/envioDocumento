<template>
    <div>
        <ModalHeader
            :title="'Upload de arquivos'"
            @close="$emit('close')"
        />

        <h1>Opções</h1>

        <div>
            <router-link to="/relatorio">Relatório</router-link>
            <router-link to="/relatorio">Meus Clientes</router-link>
        </div>
    </div>
</template>

<script lang="ts">
import ModalHeader from '../ModalHeader.vue';

export default {
    name: 'UserOptionsModal',
    components: {
        ModalHeader,
    },
    data() {
        return {
            
        }
    },
}
</script>

<style scoped>
    .modal-item {
        background-color: #fefefe !important;
    }
</style>