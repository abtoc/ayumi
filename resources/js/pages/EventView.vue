<script setup>
import { ref, onMounted } from 'vue';
import { VPullToRefresh } from 'vuetify/labs/VPullToRefresh';
import { useRoute } from 'vue-router'
import { useLoginState } from '../stores/LoginState';
import SubLayout from '../layouts/SubLayout.vue';
import ClipboardComponent from '../components/ClipboardComponent.vue';

const route = useRoute()
const st = useLoginState()

const events = ref([])

const pullDownThreshold = ref(64)

const loading = async () => {
    if(st.loggedin){
        await axios.get('/api/events/'+route.params.id)
        .then((res) => {
            console.log(res)
            events.value = res.data.detail
        }).catch((err) => {
            console.log(err)
            if((err.status == 401) || (err.status == 419)){
                st.logout()
            }
            console.log('events err:' + err)
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

const checked = (id, value) => {
    events.value.dates.forEach((date) => {
        if(date.id === id){
            date.collected = value
        }
    })
}

const click = (id) => {
    axios.get('/sanctum/csrf-cookie')
        .then((res) => {
            axios.put('/api/toggle/'+id, {
            }).then((res) => {
                console.log(res)
                checked(res.data.detail.value)
            }).catch((err) => {
                console.log(err)
                if((err.status == 401) || (err.status == 419)){
                    st.logout()
                }
                console.log('events err:' + err)
            })
        })
}
</script>

<template>
<SubLayout title="相互スクショ管理">
    <v-table>
        <thead>
            <th>日付</th>
            <th>未提出</th>
            <th></th>
        </thead>
        <tbody>
            <tr>
                <th>
                    イベント名
                </th>
                <td colspan="2">
                    {{ events.name  }}
                </td>
            </tr>
            <tr>
                <th>
                    日程
                </th>
                <td colspan="2">
                    {{ events.start_on }}〜{{ events.end_on }}
                </td>
            </tr>
            <tr
                v-for="date in events.dates"
            >
                <td>
                    <a :href="date.url" target="_blank">{{ date.date  }}</a>
                </td>
                <td>
                    <span v-if="!date.collected">{{ date.no_submitted }}</span>
                </td>
                <td>
                    <div class="d-flex flex-row align-center justify-end">
                        <ClipboardComponent :url="date.url"></ClipboardComponent>
                        <v-checkbox
                            v-model="date.collected"
                            hide-details
                            :key="date.id"
                            @click="click(date.id)"
                        ></v-checkbox>
                    </div>
                </td>
            </tr>
        </tbody>
    </v-table>
</SubLayout>
</template>

