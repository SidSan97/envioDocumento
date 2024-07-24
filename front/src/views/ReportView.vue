<template>
    <div>
        <h1>relatorio</h1>

        <label for="filter">Usar Filtro</label>
        <input type="checkbox" name="" id="filter" @click="showFilters()">

        <div class="mb-4" v-if="filter">
            <label for="year">Ano:</label>
            <input type="number" id="year" class="form-control mb-2" v-model="year"> 

            <label for="month">Mês:</label>
            <select class="form-control mb-2" name="" id="month" v-model="month">
                <option value="1">Janeiro</option>
                <option value="2">Fevereiro</option>
                <option value="3">Março</option>
                <option value="4">Abril</option>
                <option value="5">Maio</option>
                <option value="6">Junho</option>
                <option value="7">Julho</option>
                <option value="8">Agosto</option>
                <option value="9">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>
            </select>

            <label for="departament">Departamento: </label>
            <select name="" id="departament" class="mb-2 form-control">
                <option value="">Fiscal</option>
                <option value="">Pessoal</option>
                <option value="">Contabíl</option>
                <option value="">Societário</option>
            </select>
            <button class="btn btn-success mt-2" @click="filterData()">Filtrar</button>
        </div>

        <table class="table">
            <thead class="thead-dark">
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Razão Social</th>
                    <th scope="col">Data</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, key) in documents" :key="key">
                    <th scope="row">{{ key + 1 }}</th>
                    <td>
                        <a :href="url + '/backend/public/storage/' + item.nome_doc" target="_blank" rel="noopener noreferrer">
                            Ver documento
                        </a>
                    </td>
                    <td>{{ item['cliente']['nome'] }}</td>
                    <td>{{ item['data_upload'] }}</td>
                    <td>
                        <button class="btn btn-success">Opções</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script lang="ts">
    import { useAuthStore } from '@/stores/auth';
    import { useRouter } from 'vue-router';
    import { closeModal, pushModal } from 'jenesius-vue-modal';
    import axios from 'axios';

    export default {
        data() {
            return {
                documents: [],
                data: [],
                error: null,
                year: 0,
                month: 0,
                filter: false,
                url: window.location.protocol + '//' + window.location.host + window.location.pathname
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
            this.getCurrentData()
        },
        methods: {
            async load() {
                this.$loading.show();
                try {
                    const response = await axios.get('http://localhost/envioDocumento/backend/public/api/obter-documentos/' + this.user.id);
                    this.data      = response.data;
                    this.documents = this.data;

                }catch(error) {
                    console.error(error);

                }finally{
                    this.$loading.hide();
                    closeModal();
                }
            },

            showFilters() {
                this.filter = !this.filter;

                if(!this.filter){
                    this.load()
                }
            },

            filterData() {
                this.documents = this.data.filter(item => {
                    const month = new Date(item.data_upload).getMonth() + 1; 
                    return month == this.month;
                });

            },

            getCurrentData() {
                const data = new Date();
                const year = data.getFullYear();
                const month = (data.getMonth() + 1);
                const day = data.getDate().toString().padStart(2, '0');

                this.year = year;
                this.month = month;
            }
        },
    }
</script>

<style scoped>

</style>