<script setup>
import { ref, onMounted } from 'vue';
import { useLoginState } from '../stores/LoginState';
import axios from '../axios';

const st = useLoginState()

const dates = ref({})
const need = ref(false)

onMounted(async () => {
    if(st.loggedin){
        await axios.get('/api/screenshot')
        .then((res) => {
            console.log(res)
            need.value = res.data.detail.need
            dates.value = res.data.detail.dates
        }).catch((err) => {
            console.log(err)
            if((err.status == 401) || (err.status == 419)){
                st.logout()
            }
            console.log('visit error:'+err)
        })
    }
})

</script>

<template>
    <v-card>
        <v-card-title>相互実施中</v-card-title>
        <v-card-text>
            <div v-if="!need">
                <h3>現在相互はありません。</h3>
            </div>
            <div v-else-if="Object.keys(dates).length">
                <v-list density="compact">
                    <v-list-item v-for="(events, date) in dates"
                        :title="date"
                    >
                        <v-list density="compact">
                            <v-list-item v-for="event in events"
                                prepend-icon="mdi-cellphone-screenshot"
                                :title="event.name"
                                :href="event.url"
                                target="_blank"
                            ></v-list-item>
                        </v-list>
                    </v-list-item>
                </v-list>
            </div>
            <div v-else-if="!st.loggedin">
                <h3>ログインしてください</h3>
            </div>
            <div v-else>
                <h3>スクショの撮り忘れはありません</h3>
            </div>
        </v-card-text>
    </v-card>
</template>
