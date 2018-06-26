<template>
    <div class="content m-auto">
        <div class="col-12 m-auto">
            <div class="mt-2"><h2>Users</h2></div>
            <div class="card mt-2">
                <div class="card-header">
                    <button class="btn-success btn right" @click="createUser">Create User</button>
                    <button class="btn-danger btn right" @click="deleteUsers">Delete</button>
                </div>
                <div class="card-body">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" :class="[{disabled: !pagination.previousPageUrl}]">
                                <a class="page-link" href="#" @click="getList(pagination.previousPageUrl)">Previous</a>
                            </li>
                            <li class="page-item disabled">
                                <a class="page-link text-dark" href="#">Page {{ pagination.currentPage }} of {{ pagination.lastPage }}</a>
                            </li>
                            <li class="page-item" :class="[{disabled: !pagination.nextPageUrl}]">
                                <a class="page-link" @click="getList(pagination.nextPageUrl)" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                    <table class="table align-content-center table-bordered table-hover">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center"><input v-model="selectAll" type="checkbox"/></th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col">Postal</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr :class="[{'table-active': currentUserId == user.id}]" v-for="user in users" :key="user.id">
                            <th scope="row" class="text-center">
                                <input v-model="selected" v-if="currentUserId != user.id" :value="user.id" type="checkbox" number/>
                            </th>
                            <td>{{ user.first_name}}</td>
                            <td>{{ user.last_name}}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.address }}</td>
                            <td>{{ user.postal_code }}</td>
                            <td>{{ user.contact_no }}</td>
                            <td>
                                <button class="btn-xs btn btn-warning" @click="updateUser(user.id)">edit</button>
                                <button :disabled="currentUserId == user.id" class="btn-xs btn btn-danger" @click="deleteUser(user.id)">delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" :class="[{disabled: !pagination.previousPageUrl}]">
                                <a class="page-link" href="#" @click="getList(pagination.previousPageUrl)">Previous</a>
                            </li>
                            <li class="page-item disabled">
                                <a class="page-link text-dark" href="#">Page {{ pagination.currentPage }} of {{ pagination.lastPage }}</a>
                            </li>
                            <li class="page-item" :class="[{disabled: !pagination.nextPageUrl}]">
                                <a class="page-link" @click="getList(pagination.nextPageUrl)" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                users : [],
                user:{
                    id: 0,
                    first_name: '',
                    last_name: '',
                    email: '',
                    address: '',
                    postal_code: '',
                    contact_no: ''
                },
                userId: 0,
                pagination: {},
                edit: false,
                selected: []
            }
        },
        computed: {
            currentUserId() {
                let currentUser = this.$store.getters.getCurrentUser;
                return currentUser.id;
            },
            selectAll: {
                get: function () {

                    let _length = this.users.length;

                    if (this.selected.includes(this.currentUserId)) {

                        let index = this.selected.indexOf(this.currentUserId);

                        if (index > -1) {
                            this.selected.splice(index, 1);
                            _length--;
                        }
                    }

                    return this.users ? this.selected.length == _length : false;
                },
                set: function (value) {

                    let selected = [];

                    if (value) {

                        this.users.forEach(function (user) {
                            selected.push(user.id);
                        });
                    }

                    this.selected = selected;
                }
            }
        },
        created(){
            this.getList(false);
        },
        methods: {
            getList(pageUrl) {

                pageUrl = pageUrl || '/api/users';

                Vue.axios.get(pageUrl, {headers:this.$store.getters.getHeaders}).then((response) => {

                    let data = response.data;
                    this.users = data.data;
                    this.makePagination(data.meta, data.links);

                }).catch(error => {
                    console.log(error.response.data);
                    if (error.response.data.status == 401) {
                        alert(error.response.data.description);
                        this.$store.commit('logout', this.$router);
                    }
                });
            },
            makePagination(meta, links) {

                this.pagination = {
                    currentPage: meta.current_page,
                    lastPage: meta.last_page,
                    nextPageUrl: links.next,
                    previousPageUrl: links.prev
                };
            },
            deleteUser(userId) {

                let deleteUser = confirm("Are you sure you want to continue?");

                if (deleteUser) {
                    let currentUser = this.$store.getters.getCurrentUser;

                    if (currentUser.id != userId) {
                        Vue.axios.delete('/api/user/' + userId, {headers:this.$store.getters.getHeaders}).then((response) => {

                            let data = response.data;
                            this.getList();

                        }).catch(error => {
                            console.log(error.data);
                            if (error.response.data.status == 401) {
                                alert(error.response.data.description);
                                this.$store.commit('logout', this.$router);
                            }
                        });
                    } else {
                        alert("You cannot delete your own record.")
                    }

                }
            },
            deleteUsers() {

                let deleteUsers = confirm("Are you sure you want to continue?");

                if (deleteUsers) {
                    Vue.axios.post('/api/users/multi-delete', {'user_ids':this.selected}, {headers:this.$store.getters.getHeaders}).then((response) => {

                        let data = response.data;
                        this.getList();

                    }).catch(error => {
                        console.log(error.data);
                        if (error.response.data.status == 401) {
                            alert(error.response.data.description);
                            this.$store.commit('logout', this.$router);
                        }
                    });
                }
            },
            createUser() {
                this.$router.push('/user/create');
            },
            updateUser(userId) {
                this.$router.push('/user/update?id=' + userId);
            }
        }
    }
</script>
