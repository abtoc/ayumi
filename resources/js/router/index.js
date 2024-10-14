import { createRouter, createWebHistory } from 'vue-router';
import { useLoginState } from '../stores/LoginState';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('../pages/HomeView.vue')
        },
        {
            path: '/regist',
            name: 'regist',
            component: () => import('../pages/RegistView.vue')
        },
        {
            path: '/test',
            name: 'test',
            component: () => import('../pages/TestView.vue')
        },
    ]
})

router.beforeEach((to, from, next) => {
    const st = useLoginState()
    if(['regist'].includes(to.name)){
        console.log('begin register')
        st.registStart()
    }
    if(['regist'].includes(from.name)){
        console.log('begin register')
        st.registEnd()
    }
    next()
})

export default router
