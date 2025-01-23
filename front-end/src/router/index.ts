import { createRouter, createWebHistory } from 'vue-router';

const PATHS = {
    REGISTER: '/register',
    LOGIN: '/login',
    USER: '/user',
    REGISTERED: '/registered',
    LOGOUT: '/logout',
};

const routes = [
    { path: '/', redirect: PATHS.REGISTER },
    { path: PATHS.REGISTER, component: () => import('../views/Register.vue') },
    { path: PATHS.LOGIN, component: () => import('../views/Login.vue') },
    { path: PATHS.USER, component: () => import('../views/UserProfile.vue'), meta: { requiresAuth: true } },
    { path: PATHS.REGISTERED, component: () => import('../views/UserRegistered.vue') },
    { path: PATHS.LOGOUT, component: () => import('../components/Logout.vue') },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
