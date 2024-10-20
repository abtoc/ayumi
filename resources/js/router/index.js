import { createRouter, createWebHistory } from 'vue-router';
import { useLoginState } from '../stores/LoginState';
import { useNavigationState } from '../stores/NavigationState';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('../pages/HomeView.vue'),
        },
        {
            path: '/livers',
            name: 'livers',
            component: () => import('../pages/LiverView.vue'),
        },
        {
            path: '/regist',
            name: 'regist',
            component: () => import('../pages/RegistView.vue'),
        },
        {
            path: '/screenshot',
            name: 'screenshot',
            component: () => import('../pages/ScreenshotView.vue'),
        },
        {
            path: '/test',
            name: 'test',
            component: () => import('../pages/TestView.vue'),
        },
    ]
})

router.beforeEach((to, from, next) => {
    const st = useLoginState()
    const nav = useNavigationState();
    if(['regist'].includes(to.name)){
        console.log('begin register')
        st.registStart()
    }
    if(['regist'].includes(from.name)){
        console.log('begin register')
        st.registEnd()
    }
    if(to.name !== from.name){
        nav.close()
    }
    next()
})

export default router
