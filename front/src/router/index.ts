import { createRouter, createWebHistory } from 'vue-router'
import {useAuthStore} from '../stores/auth'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import ReportView from '../views/ReportView.vue'
import ChangePasswordView from '../views/ChangePasswordView.vue'
import MyClientsMenuView from '../views/MyClientsMenuView.vue'
import ShowClientsView from '@/views/ShowClientsView.vue'

const routes = [
  { 
    path: '/', 
    component: HomeView 
  },
  { 
    path: '/login', 
    component: LoginView
  },
  { 
    path: '/relatorio', 
    component: ReportView
  },
  { 
    path: '/alterar-senha', 
    component: ChangePasswordView
  },
  { 
    path: '/menu-clientes', 
    component: MyClientsMenuView
  },
  { 
    path: '/detalhes-cliente/:id?',
   component: ShowClientsView 
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  if (to.path !== '/login' && !authStore.token) {
      next('/login');
  }
  else if (to.path === '/login' && authStore.token) {
      next('/');
  } else {
      next();
  }
});

export default router
