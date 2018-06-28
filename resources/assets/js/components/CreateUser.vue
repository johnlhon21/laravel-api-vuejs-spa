<template>
    <div class="content m-auto">
        <div class="col-10 m-auto">
            <div class="mt-2"><h2>Create User</h2></div>
            <div class="card mt-2">
                <div class="card-header">
                    <button class="btn-success btn right" @click="showUsers">Show Users</button>
                </div>
                <div class="card-body">
                    <div v-if="message!=null" class="alert alert-dismissible fade show" :class="alertClass" role="alert">
                        <strong>Alert!</strong> {{ message }}
                        <button @click="clearMessage()" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <h6>Account Info</h6>
                    <hr class="bg-light">
                    <form data-vv-scope="createUserForm">
                        <div class="row">
                            <div class="col">
                                <input v-model="user.email" v-validate="'required|email'" type="text" class="form-control" name="email" id="email" placeholder="Email Address">
                                <small class="text-danger" v-show="errors.has('createUserForm.email')">{{ errors.first('createUserForm.email') }}</small>
                            </div>
                            <div class="col">
                                <input v-model="user.password" v-validate="'required'" type="password" name="password" class="form-control" id="password" placeholder="Password">
                                <small class="text-danger" v-show="errors.has('createUserForm.password')">{{ errors.first('createUserForm.password') }}</small>
                            </div>
                        </div>
                    <h6 class="mt-4">Personal Info</h6>
                    <hr class="bg-light">
                        <div class="row">
                            <div class="col">
                                <input v-model="user.first_name" v-validate="'required'" name="first_name" type="text" class="form-control" placeholder="First name">
                                <small class="text-danger" v-show="errors.has('createUserForm.first_name')">{{ errors.first('createUserForm.first_name') }}</small>
                            </div>
                            <div class="col">
                                <input v-model="user.last_name" v-validate="'required'" name="last_name" type="text" class="form-control" placeholder="Last name">
                                <small class="text-danger" v-show="errors.has('createUserForm.last_name')">{{ errors.first('createUserForm.last_name') }}</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input v-model="user.address" v-validate="'required'" name="address" type="text" class="form-control" placeholder="Address">
                                <small class="text-danger" v-show="errors.has('createUserForm.address')">{{ errors.first('createUserForm.address') }}</small>
                            </div>
                            <div class="col">
                                <input v-model="user.postal_code" v-validate="'required'" name="postal_code" type="text" class="form-control" placeholder="Postal Code">
                                <small class="text-danger" v-show="errors.has('createUserForm.postal_code')">{{ errors.first('createUserForm.postal_code') }}</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input v-model="user.contact_no" v-validate="'required'" name="contact_no" type="text" class="form-control" placeholder="Contact No.">
                                <small class="text-danger" v-show="errors.has('createUserForm.contact_no')">{{ errors.first('createUserForm.contact_no') }}</small>
                            </div>
                            <div class="col"></div>
                        </div>

                        <hr class="bg-light">

                        <div class="row">
                            <div class="col">
                                <button ref="reset" type="reset" class="btn btn-warning btn-block">Clear</button>
                            </div>
                            <div class="col">
                                <button @click.prevent="validateForm()" class="btn btn-primary btn-block">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user : {
                    email : null,
                    password : null,
                    first_name: null,
                    last_name: null,
                    address: null,
                    postal_code: null,
                    contact_no: null
                },
                message : null,
                alertClass : ''
            }
        },
        mounted(){
            console.log(this.$store.state.isLoggedIn);
        },
        methods: {
            createUser() {
                Vue.axios.post('/api/user', this.user, {headers:this.$store.getters.getHeaders}).then((response) => {

                    let data = response.data;

                    if (data.data != null) {
                        this.message = "User successfully created.";
                        this.alertClass = "alert-info";
                        this.clearForm();
                    } else {
                        this.message = data.message;
                        this.alertClass = "alert-danger";
                    }

                    setTimeout(() => {
                        this.clearMessage();
                    }, 2000);

                }).catch(error => {

                    if (error.response.data.status == 401) {
                        alert(error.response.data.description);
                        this.$store.commit('logout', this.$router);
                    }
                    this.message = "Cannot create user.";
                    this.alertClass = "alert-danger";
                    console.log(error.data);
                });
            },
            validateForm() {
                this.$validator.validateAll("createUserForm").then((result) => {
                    if (result) {
                        this.createUser();
                    }
                });
            },
            clearMessage() {
                this.message = null;
            },
            clearForm() {

                this.$validator.reset('createUserForm');

                this.user.email = '';
                this.user.password = '';
                this.user.first_name = '';
                this.user.last_name = '';
                this.user.address = '';
                this.user.postal_code = '';
                this.user.contact_no = '';
            },
            showUsers() {
                this.$router.push('/users');
            }
        }
    }
</script>

<style>
    div.row {
        margin-top: 20px;
    }
</style>
