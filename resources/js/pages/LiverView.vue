<script setup>
import { ref, onMounted } from 'vue';
import { VPullToRefresh } from 'vuetify/labs/VPullToRefresh';
import { useLoginState } from '../stores/LoginState';
import MainLayout from '../layouts/MainLayout.vue'
import LogoutComponent from '../components/LogoutComponent.vue';

const st = useLoginState()

const livers = ref([])

const pullDownThreshold = ref(64)

const lodaing = async () => {
    if(st.loggedin){
        await axios.get('/api/livers')
        .then((res) => {
            livers.value = res.data.detail
        }).catch((err) => {
            console.log(err)
            if((err.status == 401) || (err.status == 419)){
                st.logout()
            }
            console.log('livers err:' + err)
        })
    }
}

const load = async ({done}) => {
    console.log('loading')
    lodaing()
    await new Promise(resolve => setTimeout(() => resolve(), 2000))
    console.log('load finish')
    done('ok')
}

onMounted(async () => {
    lodaing()
})

</script>

<template>
<MainLayout title="登録ライバー">
    <template v-slot:navigation>
        <v-list-item to='/' title="ホーム"></v-list-item>
        <v-list-item to='/regist' title="新規登録" v-if="!st.loggedin"></v-list-item>
        <v-list-item to='/livers' title="登録ライバー" active="true"></v-list-item>
        <v-list-item to='/clients' title="相互スクショ管理"></v-list-item>
        <LogoutComponent></LogoutComponent>
    </template>

    <v-container>
        <v-pull-to-refresh
        :pull-down-threshold="pullDownThreshold"
        @load="load"
        >
            <v-list
                density="compact"
                :key="renderKey"
            >
                <v-list-item
                    v-for="liver in livers"
                >
                    <v-list-item-title>
                        <v-icon icon="mdi-account" class="d-inline"></v-icon>
                        <a :href="liver.url" target="_blank" class="d-inline">
                            {{ liver.name }}
                        </a>
                    </v-list-item-title>
                    <v-list
                        density="compact"
                    >
                        <v-list-item v-for="event in liver.events">
                            {{ event.start_on }}〜{{ event.end_on }}：{{ event.name }}
                        </v-list-item>
                    </v-list>
                </v-list-item>
            </v-list>
        </v-pull-to-refresh>
    </v-container>

</MainLayout>
</template>

<style>

a {
    text-decoration: none;
    color: rgba(0, 0, 0, 87);
}

</style>
