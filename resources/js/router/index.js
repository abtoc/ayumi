import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('../pages/HomeView.vue')
        },
        {
            path: '/test',
            name: 'test',
            component: () => import('../pages/TestView.vue')
        },
    ]
})

export default router
