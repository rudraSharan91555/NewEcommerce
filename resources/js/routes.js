import { createWebHistory, createRouter } from 'vue-router'
import Layout from './frontTemplate/Layout.vue';
import Index from './frontTemplate/Index.vue';



const routes = [

    {
        name: 'Index',
        path: '/',
        component:Index,

    },
    
    // {
    //     name: 'Category',
    //     path: '/category/:slug?',
    //     component: Category,

    // },
   

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
