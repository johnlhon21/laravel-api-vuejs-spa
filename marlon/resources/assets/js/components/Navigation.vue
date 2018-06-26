<template>
    <nav class="navbar navbar-light bg-light">
        <span class="navbar-brand mb-0 h1">Laravel & Vue.js - API Test</span>
        <span class="navbar-brand mb-0 text-right">
            <template v-if="isLoggedIn">
                <small>Welcome, {{ currentUser.first_name}}</small> |
                <small><a href="" @click.prevent="logout">Logout</a></small>
            </template>
            <template v-else>
                <small><router-link to = "/login">Login</router-link></small>
            </template>
        </span>
    </nav>
</template>
<script>
    export default {
        data () {
            return {

            }
        },
        computed: {
            isLoggedIn () {
                return this.$store.state.isLoggedIn;
            },
            currentUser () {
                let user = this.$store.state.currentUser;
                return JSON.parse(JSON.stringify(user));
            }
        },
        methods : {
            logout() {
                this.$store.commit('logout', this.$router);
            }
        }
    }
</script>
