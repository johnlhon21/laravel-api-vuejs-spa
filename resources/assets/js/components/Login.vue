<template>
    <div class="content">
        <div class="col-4 border-info border m-auto p-5 rounded mt-lg-5">
            <div v-if="message!=null" class="alert alert-dismissible fade show" :class="alertClass" role="alert">
                <strong>Alert!</strong> {{ message }}
                <button @click="clearMessage()" type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h2>Login</h2>
            <form class="p2 mt-3" data-vv-scope="loginForm">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input data-vv-scope="loginForm" v-model="credentials.email"  type="text" v-validate="'required|email'" class="form-control border-info" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                    <small class="text-danger" v-show="errors.has('loginForm.email')">{{ errors.first('loginForm.email') }}</small>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input data-vv-scope="loginForm" v-model="credentials.password" v-validate="'required'" type="password" class="form-control border-info" id="password" name="password" placeholder="Password">
                    <small class="text-danger" v-show="errors.has('loginForm.password')">{{ errors.first('loginForm.password') }}</small>
                </div>
                <button @click.prevent="validateForm()" type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                credentials : {
                    email : null,
                    password : null
                },
                message : null,
                alertClass : ''
            }
        },
        mounted(){
            console.log(this.$store.state.isLoggedIn);
        },
        methods: {
            login() {

                Vue.axios.post('/api/login', this.credentials).then((response) => {

                    let data = response.data;

                    this.message = data.message;
                    this.alertClass = data.class;

                    if (data.data != null) {
                        setTimeout(() => {
                            this.credentials.email = null;
                            this.credentials.password = null;
                            this.clearMessage();
                            this.$store.commit('loggedIn', data.data.user);
                            this.$store.commit('setToken', data.data.token);
                            this.$router.push('/users');
                        }, 1000);
                    }

                }).catch(error => {
                    console.log(error.data);
                });
            },
            validateForm() {
                this.$validator.validateAll("loginForm").then((result) => {
                    if (result) {
                        this.login();
                    }
                });
            },
            clearMessage() {
                this.message = null;
            }
        }
    }

</script>
