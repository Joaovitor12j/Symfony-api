import { createRouter, createWebHistory } from 'vue-router';
import Register from '../views/Register.vue';
import Login from "../views/Login.vue";
import UserProfile from '../views/UserProfile.vue';

const routes = [
    { path: '/register', component: Register },
    { path: '/login', component: Login },
    { path: '/user', component: UserProfile },
    // { path: '/congratulations', component: { template: '<div>Parabéns! Registro concluído.</div>' } }, implementando
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
