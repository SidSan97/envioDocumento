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

            <div class="form-group mb-2">
                <label for="userStatus">Usuário Ativo
                    <input type="checkbox" name="actived" id="actived" v-model="actived">
                </label>
            </div>
    
            <button @click="submit()" class="btn btn-primary">Registrar</button>
            
        </div>
    </div>
</template>

<script lang="ts">
    import axios from 'axios';
    import ModalHeader from '../ModalHeader.vue';
    import { useAuthStore } from '../../stores/auth';
    import { swalError, swalSuccess } from '../../utils/alerts'
    import { closeModal } from 'jenesius-vue-modal';
    import { useRouter } from 'vue-router';

    export default {
        name: 'EditClientsModal',
        components: {
            ModalHeader,
        },
        data() {
            return {
                nome: this.clientData.nome,
                email: this.clientData.email,
                cpf_cnpj: this.clientData.cpf_cnpj,
                telefone: this.clientData.telefone,
                id_user: this.clientData.id_cliente,
                responseMessage: '',
                actived: true,
            }
        },
        props: {
            clientData: {
                type: Object,
                required: true,
            },
        },
        setup() {
            const authStore = useAuthStore();
            const router = useRouter();
           
            return {
                router,
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
                    id: this.id_user,
                    cliente_ativo: this.actived ? 1 : 0,
                }

                try {
                    const response = await axios.post('http://localhost/envioDocumento/backend/public/api/editar-cliente', formData);
                    this.responseMessage = response.data.message;
                } catch (error: any) {

                    console.error(error);
                    swalError(error.response.data.error);
                }finally {
                    this.$loading.hide();
                    swalSuccess(this.responseMessage);
                    this.router.push('/')
                }
            },
        },
    }
</script>

<style scoped>
   
</style>