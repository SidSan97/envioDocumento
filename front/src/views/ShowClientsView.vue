<template>
    <div class="container">
        <h2 align="center">Relatório</h2>
    </div>
</template>

<script lang="ts">
    import axios from 'axios';
    import { useAuthStore } from '@/stores/auth';
    
    export default {
        name: 'ShowClientsView',
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
                const id = this.user.id_cargo == 1 ? this.id : this.user.id;
                
                const response = await axios.get('http://localhost/envioDocumento/backend/public/api/listar-clientes/' + id);
                this.clients   = response.data;
            }
        }
    }
</script>

<style scoped>
    
</style>