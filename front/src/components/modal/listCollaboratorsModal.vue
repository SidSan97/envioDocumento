<template>
    <div>
        <ModalHeader
            :title="'Upload de arquivos'"
            @close="$emit('close')"
        />

        <h1>Lista de Colaboradores</h1>

        <table class="table">
            <thead class="thead-dark">
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Razão Social</th>
                    <th scope="col">Email</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, key) in data" :key="key">
                    <th scope="row">{{ key + 1 }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>
                        <button class="btn btn-success mr-3">
                            <router-link :to="{ path: 'detalhes-cliente/' + item.id_user, query: { item: decodeItem(item) }}" target="_blank" rel="noopener noreferrer">Ver dados</router-link>
                        </button>
                        <button class="btn btn-danger">
                            Excluir
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script lang="ts">
    import { useAuthStore } from '@/stores/auth';
    import ModalHeader from '../ModalHeader.vue';
    import { useRouter } from 'vue-router';
    import { closeModal, pushModal } from 'jenesius-vue-modal';
    import axios from 'axios';
    import { encode } from '@/utils/encodeDecode';

    export default {
        name: 'listCollaboratorsModal',
        components: {
            ModalHeader,
        },
        data() {
            return {
                data: [],
                error: null,
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
            this.load();
        },
        methods: {
            async load() {
                this.$loading.show();
                try {
                    const response = await axios.get('http://localhost/envioDocumento/backend/public/api/listar-colaboradores');
                    this.data      = response.data;

                }catch(error) {
                    console.error(error);

                }finally{
                    this.$loading.hide();
                }
            },

            decodeItem(item: any) {
                return encode(item);
            },

            /*modalOptions() {
                pushModal(modalOtions);
            }*/
        },
    }
</script>

<style scoped>

</style>