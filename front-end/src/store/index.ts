import { createStore } from 'vuex';

const store = createStore({
    state() {
        return {
            user: {
                name: '',
                email: '',
                password: ''
            }
        };
    },
    mutations: {
        CLEAR_USER(state: any) {
            state.user = { name: '', email: '', password: '' };
        }
    },
    actions: {
        logout({ commit }: any) {
            commit('CLEAR_USER');
        }
    }
});

export default store;
