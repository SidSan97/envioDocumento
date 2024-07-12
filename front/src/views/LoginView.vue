<template>
    <div>
        <img src="@/assets/LOGO.png" alt="" srcset="">

        <div class="formLogin">
            <form @submit.prevent="login">
                <div class="form-group mb-4">
                    <label for="exampleInputEmail1">Email</label>
                    <input v-model="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                </div>

                <div class="form-group mb-4">
                    <label for="exampleInputPassword1">Senha</label>
                    <input v-model="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
        </div>
    </div>
</template>

<script>
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

export default {
    data() {
        return {
            email: '',
            password: '',
            error: '',
        };
    },
    setup() {
        const authStore = useAuthStore();
        const router = useRouter();

        if (authStore.token) {
            router.push('/');
        }

        return { authStore, router };
    },
    methods: {
        async login() {
            try {
                await this.authStore.login(this.email, this.password);
                this.router.push('/');
            } catch (err) {
                this.error = 'Email ou senha incorretos.'; 
            }

            return { authStore, router };
        },
    }
};
</script>

<style scoped>
    .formLogin{
        width: 400px;
    }
</style>