<template>
    <div class="container">

        <h1 align="center">Alterar senha</h1> <br>

        <div class="row">
            <form @submit.prevent="changePassword">
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Senha</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Insira sua senha" v-model="password" :style="getClassInput()">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword2" class="col-sm-2 col-form-label">Repita a senha</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword2" placeholder="Confirme a senha" v-model="passwaord2" :style="getClassInput()">
                    </div>
                </div>

                <p v-if="differentsPasswords" class="text-danger">A senhas não coincidem</p>

                <button class="btn btn-success" type="submit">Enviar</button>
            </form>
        </div>
    </div>
</template>

<script lang="ts">
    import axios from 'axios';
    import { useAuthStore } from '@/stores/auth';

    export default {
        data() {
            return {
                password: '',
                passwaord2: '',
                differentsPasswords: false,
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
        methods: {

            async changePassword() {
                this.$loading.show()
                if(this.passwaord2 !== this.password) {
                    console.log("As senhas são diferentes.");
                    return;
                }

                let formData = {
                    'senha': this.password,
                    'senha2': this.passwaord2,
                    'id': this.user.id
                }

                try {
                    const response = await axios.post('http://localhost/envioDocumento/backend/public/api/alterar-senha', formData)
                    this.responseMessage = response.data.message;

                } catch(error: any) {
                    if (error.response && error.response.data && error.response.data.message) {
                        this.responseMessage = error.response.data.message;
                    } else {
                        this.responseMessage = 'Erro ao enviar o formulário. Por favor, tente novamente.';
                    }

                } finally {
                    this.$loading.hide();
                }
            },

            getClassInput() {

                if(this.password !== this.passwaord2) {
                    this.differentsPasswords = true;
                    return 'border: 1px solid red';

                } else {
                    this.differentsPasswords = false;
                }
            },
        }
    }
</script>

<style scoped>

</style>