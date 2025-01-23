import { createRouter, createWebHistory } from 'vue-router';
import Register from '../views/Register.vue';
import Login from "../views/Login.vue";
import UserProfile from '../views/UserProfile.vue';
import UserRegistered from "../views/UserRegistered.vue";
import Logout from "../components/Logout.vue";

const routes = [
    { path: '/', redirect: '/register' },
    { path: '/register', component: Register },
    { path: '/login', component: Login },
    { path: '/user', component: UserProfile, meta: { requiresAuth: true } },
    { path: '/registered', component: UserRegistered },
    { path: '/logout', component: Logout },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
