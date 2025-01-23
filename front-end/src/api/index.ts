import axios from 'axios';
import type {Credentials, User} from "../models/User.ts";

const apiClient = axios.create({
    baseURL: 'http://localhost:8000',
    withCredentials: true,
    headers: {
        'Content-Type': 'application/json',
    },
    timeout: 10000
});

const ENDPOINTS = {
    REGISTER: '/register',
    LOGIN: '/login',
    LOGOUT: '/logout',
    GET_USER: '/user',
};

export default {
    register(user: User) {
        return apiClient.post(ENDPOINTS.REGISTER, user);
    },
    login(credentials: Credentials) {
        return apiClient.post(ENDPOINTS.LOGIN, credentials);
    },
    logout() {
        return apiClient.post(ENDPOINTS.LOGOUT);
    },
    getUser() {
        return apiClient.get(ENDPOINTS.GET_USER);
    },
};
