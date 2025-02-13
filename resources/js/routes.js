import { createWebHistory, createRouter } from 'vue-router'
import test from './test.vue'
import Layout from './frontTemplate/Layout.vue';



const routes = [

    {
        name: 'Layout',
        path: '/',
        component:Layout,

    },
   

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
