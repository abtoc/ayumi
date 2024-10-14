<script setup>
import { ref } from 'vue';
import { RouterView, RouterLink } from 'vue-router';
import axios from './axios';
import LoginView from './pages/LoginView.vue';
import { useLoginState } from './stores/LoginState';

const drawer = ref(false)
const st = useLoginState()

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
    <v-app>
        <v-app-bar color="primary">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title>
                Ayumi System
            </v-app-bar-title>
        </v-app-bar>

        <v-navigation-drawer permanennt v-model="drawer">
            <v-list-item to='/' title="ホーム"></v-list-item>
            <v-list-item to='/test' title="テスト"></v-list-item>
            <v-list-item @click="logout" title="ログアウト"></v-list-item>
        </v-navigation-drawer>

        <v-main>
            <RouterView />
        </v-main>
        <LoginView />
    </v-app>
</template>
