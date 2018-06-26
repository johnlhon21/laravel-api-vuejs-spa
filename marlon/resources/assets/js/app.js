/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import 'es6-promise/auto';
import Vue from 'vue';
import axios from 'axios'
import VueAxios from 'vue-axios'
import VeeValidate from 'vee-validate';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import { store } from './store.js';
import { routes } from './routes.js';


Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(VueAxios, axios);
Vue.use(Vuex);


Vue.component('navigation', require('./components/Navigation.vue'));
Vue.component('mainpage', require('./components/MainApp.vue'));


const router = new VueRouter({
    routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {

    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const isLoggedIn = store.state.isLoggedIn;

    if(requiresAuth && !isLoggedIn) {
        next('/login');
    } else if(to.path == '/login' && isLoggedIn){
        next('/');
    }
    else if(to.path == '/user' && isLoggedIn){
        next('/users');
    }
    else {
        next();
    }

});

const app = new Vue({
    data: {
    },
    router,
    routes,
    store,
    el: '#app',
});
