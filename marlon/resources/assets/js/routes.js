import Login from './components/Login.vue';
import Users from './components/Users.vue';
import UpdateUser from './components/UpdateUser.vue';
import CreateUser from './components/CreateUser.vue';


export const routes = [
    {
        path: '/login',
        component: Login,
        meta: { requiresAuth: false }
    },
    {
        path: '/',
        component: Users,
        meta: { requiresAuth: true }
    },
    {
        path: '/users',
        component: Users,
        meta: { requiresAuth: true }
    },
    {
        path: '/user/update',
        component: UpdateUser,
        meta: { requiresAuth: true }
    },
    {
        path: '/user/create',
        component: CreateUser,
        meta: { requiresAuth: true }
    }
];
