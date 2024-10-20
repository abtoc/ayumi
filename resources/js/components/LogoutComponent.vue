<script setup>
import { useLoginState } from '../stores/LoginState';
import { useNavigationState } from '../stores/NavigationState';

const st = useLoginState()
const nav = useNavigationState()

const logout = () => {
    axios.get('/sanctum/csrf-cookie')
        .then((res) => {
            axios.post('/api/logout'
            ).then((res) => {
                st.logout()
                nav.close()
            }).catch((err) => {
                console.log('logout error:'+err)
            })
        })
}
</script>

<template>
        <v-list-item @click="logout" title="ログアウト"></v-list-item>
</template>
