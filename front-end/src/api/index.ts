import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://localhost:8000',
    withCredentials: true,
    headers: {
        'Content-Type': 'application/json',
    },
});

export default {
    register(user: { name: string; email: string; password: string }) {
        return apiClient.post('/register', user);
    },
    login(credentials: { email: string; password: string }) {
        return apiClient.post('/login', credentials);
    },
    getUser() {
        console.log('teste')
        console.log(apiClient.get('/user'))
        return apiClient.get('/user');
    },
};
