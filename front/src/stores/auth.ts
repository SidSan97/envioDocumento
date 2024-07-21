import { defineStore } from 'pinia';
import axios from 'axios';
import { useRouter } from 'vue-router';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('token') || null,
        user: JSON.parse(localStorage.getItem('user')) || null
    }),
    actions: {
        async login(email: string, password: string) {
            const response = await axios.post('http://localhost/envioDocumento/backend/public/api/login', { email, password });
            this.token = response.data.token;
            this.user = response.data.user;

            localStorage.setItem('token', this.token);
            localStorage.setItem('user', JSON.stringify(this.user));

            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

            return {
                user: this.user
            }
        },

        async logout() {
            if (this.token) {
                try {
                    await axios.post('http://localhost/envioDocumento/backend/public/api/logout', {}, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    });
                } catch (error: any) {
                    console.error('Erro ao fazer logout:', error.response);
                }
            }
            this.token = null;
            this.user = null;

            localStorage.removeItem('token');
            localStorage.removeItem('user');

            delete axios.defaults.headers.common['Authorization'];
        }
    }
});
