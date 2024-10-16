<script setup>
import { ref } from 'vue';
import VisitComponent from '../components/VisitComponent.vue';
import ScreenshotComponent from '../components/ScreenshotComponent.vue';
import MainLayout from '../layouts/MainLayout.vue';
import { VPullToRefresh } from 'vuetify/labs/VPullToRefresh'
import { useLoginState } from '../stores/LoginState';

const st = useLoginState()

st.$subscribe((mutation, state) => {
    if(st.loggedin){
        renderKey.value = renderKey.value + 1
        console.log('visit refresh')
    }
})

const pullDownThreshold = ref(64)
const renderKey = ref(0)

async function load({done}) {
    console.log('loading')
    await new Promise(resolve => setTimeout(() => resolve(), 2000))
    renderKey.value = renderKey.value + 1
    console.log('load finish')
    done('ok')
}

const logout = () => {
    axios.get('/sanctum/csrf-cookie')
        .then((res) => {
            axios.post('/api/logout'
            ).then((res) => {
                console.log(res)
                st.logout()
                drawer.value = false
            }).catch((err) => {
                console.log('logout error:'+err)
            })
        })
}

</script>

<template>
<MainLayout title="Ayumi System">
    <template v-slot:navigation>
        <v-list-item to='/' title="ホーム"></v-list-item>
        <v-list-item to='/regist' title="新規登録" v-if="!st.loggedin"></v-list-item>
        <v-list-item @click="logout" title="ログアウト"></v-list-item>
    </template>
    <v-pull-to-refresh
        :pull-down-threshold="pullDownThreshold"
        @load="load"
    >
        <VisitComponent :key="renderKey" />
        <ScreenshotComponent :key="renderKey" />
    </v-pull-to-refresh>
</MainLayout>
</template>

