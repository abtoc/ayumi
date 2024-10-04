<script setup>
import { ref, onMounted } from 'vue';

const date = ref()
const events = ref([])

onMounted(async () => {
    const res = await axios.get('/api/visit')
    date.value = res.data.detail.date
    events.value = res.data.detail.events
    console.log(res)
})

</script>

<template>
    <v-card>
        <v-card-title>開催中のイベント({{ date }})</v-card-title>
        <v-card-text>
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
        </v-card-text>
    </v-card>
</template>

<style lang="scss" scope>
</style>
