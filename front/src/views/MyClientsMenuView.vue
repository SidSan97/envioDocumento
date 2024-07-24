<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 p-3 bg-success">
                <div class="mb-4 menu-painel" @click="listCollaboratorsModal()">         
                    <i class="fas fa-rss-square"></i>
                    <br>
                    <span>Listar Colaboradores</span>
                </div>
            </div>

            <div class="col-lg-6">
                oi 2
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { pushModal, openModal } from 'jenesius-vue-modal';
    import { useAuthStore } from '../stores/auth';
    import { useRouter } from 'vue-router';
    import listCollaboratorsModal from '@/components/modal/listCollaboratorsModal.vue';
    import ModalHeader from '@/components/ModalHeader.vue';

    export default {
        name: 'MyClientsMenuView',
        components: {
            ModalHeader,
            listCollaboratorsModal,
        },
        data() {
            return {
                
            }
        },
        methods: {
            listCollaboratorsModal(){
                pushModal(listCollaboratorsModal)
            },
        }
    }
</script>

<style scoped>
    
</style>