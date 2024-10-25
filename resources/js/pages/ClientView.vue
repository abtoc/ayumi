<script setup>
import { ref, onMounted } from 'vue';
import { VPullToRefresh } from 'vuetify/labs/VPullToRefresh';
import { useLoginState } from '../stores/LoginState';
import MainLayout from '../layouts/MainLayout.vue';
import LogoutComponent from '../components/LogoutComponent.vue';
import ClipboardComponent from '../components/ClipboardComponent.vue';

const st = useLoginState()

const clients = ref([])

const pullDownThreshold = ref(64)

const loading = async () => {
    if(st.loggedin){
        await axios.get('/api/clients')
        .then((res) => {
            console.log(res)
            clients.value = res.data.detail
        }).catch((err) => {
            console.log(err)
            if((err.status == 401) || (err.status == 419)){
                st.logout()
            }
            console.log('clients err:' + err)
        })
    }
}

const load = async ({done}) => {
    console.log('loading')
    loading()
    await new Promise(resolve => setTimeout(() => resolve(), 2000))
    console.log('load finish')
    done('ok')
}

onMounted(async () => {
    loading()
})

const click = (id, ev) => {
    axios.get('/sanctum/csrf-cookie')
        .then((res) => {
            axios.put('/api/toggle/'+id, {
            }).then((res) => {
                ev.srcElement.checked = res.data.detail.value
            }).catch((err) => {
                console.log(err)
                if((err.status == 401) || (err.status == 419)){
                    st.logout()
                }
                console.log('clients err:' + err)
            })
        })
}

</script>

<template>
<MainLayout title="相互スクショ管理">
    <template v-slot:navigation>
        <v-list-item to='/' title="ホーム"></v-list-item>
        <v-list-item to='/regist' title="新規登録" v-if="!st.loggedin"></v-list-item>
        <v-list-item to='/livers' title="登録ライバー"></v-list-item>
        <v-list-item to='/clients' title="相互スクショ管理" active="true"></v-list-item>
        <LogoutComponent></LogoutComponent>
    </template>
    <v-pull-to-refresh
        :pull-down-threshold="pullDownThreshold"
        @load="load"
    >
        <v-list
            density="compact"
        >
            <v-list-item
                v-for="client in clients"
                :title="client.name"
            >
                <v-list
                    density="compact"
                >
                    <v-list-item
                        v-for="event in client.events"
                    >
                        <div class="d-flex flex-row justify-space-between align-center">
                            <div>
                                <router-link :to="{name: 'events', params:{id:event.id}}">{{ event.name }}</router-link><br>
                                {{ event.start_on }}〜{{ event.end_on }}
                            </div>
                            <div class="d-flex flex-row align-center">
                                <ClipboardComponent :url="client.url"></ClipboardComponent>
                                <v-checkbox
                                    v-model="event.delivered"
                                    hide-details
                                    :key="event.id"
                                    @click="click(event.id, $event)"
                                ></v-checkbox>
                            </div>
                        </div>
                    </v-list-item>
                </v-list>
            </v-list-item>
        </v-list>
    </v-pull-to-refresh>
</MainLayout>
</template>

<style>
a, a:hover, a:visited {
    text-decoration: none;
    color: inherit;
}
</style>
