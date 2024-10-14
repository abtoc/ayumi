<script setup>
import { ref, onMounted } from 'vue';
import { useLoginState } from '../stores/LoginState';
import axios from '../axios';

const st = useLoginState()

const date = ref()
const events = ref([])

onMounted(async () => {
    if(st.loggedin){
        await axios.get('/api/visit')
        .then((res) => {
            date.value = res.data.detail.date
            events.value = res.data.detail.events
        }).catch((err) => {
            console.log(err)
            if(err.status == 401){
                st.logout()
            }
            console.log('visit error:'+err)
        })
    }
})

</script>

<template>
    <v-card>
        <v-card-title>開催中のイベント({{ date }})</v-card-title>
        <v-card-text>
            <div
                v-if="events.length"
            >
                <v-list
                    density="compact"
                >
                    <v-list-item v-for="event in events"
                        :title="event.title"
                    >
                            <v-list
                                density="compact"
                            >
                                <v-list-item v-for="liver in event.livers"
                                    prepend-icon="mdi-account"
                                >
                                    <v-btn :href="liver.url" target="_blank" variant="text">{{ liver.name }}</v-btn>
                                </v-list-item>
                            </v-list>
                    </v-list-item>
                </v-list>
            </div>
            <div v-else-if="!st.loggedin">
                <h3>ログインしてください</h3>
            </div>
            <div v-else>
                <h3>現在、イベントはありません</h3>
            </div>
        </v-card-text>
    </v-card>
</template>

<style lang="scss" scope>
</style>
