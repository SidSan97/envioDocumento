<template>
    <div class="container">
        <br><br><br>
        <h2 align="center">Relatório</h2>

        <button class="btn btn-warning">
            <a href="/" class="nav-link mb-4 text-dark">Voltar</a>
        </button>
        
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Razão Social</th>
                    <th scope="col">Email</th>
                    <th scope="col">CPF/CNPJ</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, key) in clients" :key="key">
                    <th scope="row">{{ key + 1 }}</th>
                    <td>{{ item.nome }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.cpf_cnpj }}</td>
                    <td>{{ item.telefone }}</td>
                    <td>
                        <button class="btn btn-primary" @click="showModalEdit(item)">
                            Editar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script lang="ts">
    import axios from 'axios';
    import { useAuthStore } from '@/stores/auth';
    import { swalError } from '@/utils/alerts';
    import { pushModal } from 'jenesius-vue-modal';
    import EditClientsModal from '../components/modal/EditClientsModal.vue';
    
    export default {
        name: 'ShowClientsView',
        components: {
            EditClientsModal,
        },
        data(){
            return {
                id: this.$route.params.id,
                clients: [],
            }
        },
        created() {
            this.load();
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
            async load(){

                this.$loading.show()
                try {
                    const id = this.user.id_cargo == 1 ? this.id : this.user.id;
                
                    const response = await axios.get('http://localhost/envioDocumento/backend/public/api/listar-clientes/' + id);
                    this.clients   = response.data.clients;

                }catch(error) {
                    console.error(error)
                    swalError("Erro ao buscar dados dos clientes");

                }finally {
                    this.$loading.hide();
                }
            },

            showModalEdit(data: any) {

                pushModal(EditClientsModal, {clientData: data});
            }
        }
    }
</script>

<style scoped>
    
</style>