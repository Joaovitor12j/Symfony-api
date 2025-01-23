import { createStore } from 'vuex';
import type { User } from '@/models/User';

interface State {
    user: User;
}

const store = createStore<State>({
    state: () => ({
        user: {
            name: '',
            email: '',
        },
    }),
    mutations: {
        CLEAR_USER(state) {
            state.user = { name: '', email: '' };
        },
    },
    actions: {
        clearUserState({ commit }) {
            commit('CLEAR_USER');
        },
    },
});

export default store;
