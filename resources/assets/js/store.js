import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist';

Vue.use(Vuex);

const vuexLocalStorage = new VuexPersist({
    key: 'vuex',
    storage: window.localStorage,
});

export const store = new Vuex.Store({
    state: {
        token: null,
        isLoggedIn: false,
        currentUser : {},
    },
    mutations: {
        logout (state, router) {
            state.token = null;
            state.isLoggedIn = false;
            state.user = {};
            router.push('/login');
        },
        loggedIn (state, user) {
            state.isLoggedIn = true;
            state.currentUser = user;
        },
        setToken (state, _token) {
            state.token =_token;
        },
        setUser(state, user) {
            state.currentUser = user;
        }
    },
    getters: {
        getHeaders (state) {
            let headers = {
                'Authorization': 'Bearer ' + state.token,
                'Content-Type' : 'application/json'
            };

            return headers;
        },
        getToken (state) {
            return state.token;
        },
        getCurrentUser (state) {
            return state.currentUser;
        }
    },
    plugins: [vuexLocalStorage.plugin]
});
