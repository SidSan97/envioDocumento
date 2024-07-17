import './assets/main.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axios from 'axios';
import Loading from './plugin/loading'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import './plugin/loading.scss'

axios.defaults.withCredentials = true;

const app = createApp(App)

app.use(createPinia())
app.use(Loading)
app.use(router)

app.mount('#app')
