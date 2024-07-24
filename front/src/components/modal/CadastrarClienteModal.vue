<template>
    <div>
        <ModalHeader
        :title="'Cadastro de clientes'"
        @close="$emit('close')"
        />

        <div class="container mt-2">
            <h4>Formulário registro de clientes</h4>
            
            <div class="form-group mb-2">
                <label for="nome">Nome</label>
                <input v-model="nome" type="text" class="form-control" id="nome" placeholder="Digite seu nome">
            </div>

            <div class="form-group mb-2">
                <label for="email">Email</label>
                <input v-model="email" type="email" class="form-control" id="email" placeholder="Digite seu email">
            </div>
            <div class="form-group mb-2">
                <label for="cpf_cnpj">CPF/CNPJ</label>
                <input v-model="cpf_cnpj" type="text" class="form-control" id="cpf_cnpj" placeholder="Digite seu CPF ou CNPJ">
            </div>
            <div class="form-group mb-2">
                <label for="telefone">Telefone</label>
                <input v-model="telefone" type="tel" class="form-control" id="telefone" placeholder="Digite seu telefone">
            </div>
    
            <button @click="submit()" class="btn btn-primary">Registrar</button>
            
        </div>
    </div>
</template>

<script lang="ts">
    import axios from 'axios';
    import ModalHeader from '../ModalHeader.vue';
    import { useAuthStore } from '../../stores/auth';
    import { swalSuccess } from '../../utils/alerts'
    import { closeModal } from 'jenesius-vue-modal';

    export default {
        name: 'CadastrarClienteModal',
        components: {
            ModalHeader,
        },
        data() {
            return {
                nome: '',
                email: '',
                cpf_cnpj: '',
                telefone: '',
                id_user: 0,
                responseMessage: '',
            }
        },
        setup() {
            const authStore = useAuthStore();
           
            return {
                user: 
                    authStore.user,
                    logout: authStore.logout
            };
        },
        created() {
        
        },
        methods: {

            async submit() {
                this.$loading.show()

                let formData = {
                    nome: this.nome,
                    email: this.email,
                    cpf_cnpj: this.cpf_cnpj,
                    telefone: this.telefone,
                    id_user: this.user.id
                }

                try {
                    const response = await axios.post('http://localhost/envioDocumento/backend/public/api/cadastrar-cliente', formData);
                    this.responseMessage = response.data.message;
                } catch (error: any) {

                    if (error.response && error.response.data && error.response.data.message) {
                        this.responseMessage = error.response.data.message;
                    } else {
                        this.responseMessage = 'Erro ao enviar o formulário. Por favor, tente novamente.';
                    }

                }finally {
                    this.$loading.hide();
                    swalSuccess(this.responseMessage);
                }
            },
        },
    }
</script>

<style scoped>
   
</style>