<script setup>
import { ref } from 'vue';
import VisitComponent from '../components/VisitComponent.vue';
import { VPullToRefresh } from 'vuetify/labs/VPullToRefresh'

const pullDownThreshold = ref(64)
const renderKey = ref(0)

async function load({done}) {
    console.log('loading')
    await new Promise(resolve => setTimeout(() => resolve(), 2000))
    renderKey.value = renderKey.value + 1
    console.log('load finish')
    done('ok')
}

</script>

<template>
<v-container>
    Main Contents
    <div class="scrollable-container bg-surface-light">
        <v-pull-to-refresh
            :pull-down-threshold="pullDownThreshold"
            @load="load"
        >
            <VisitComponent :key="renderKey" />
        </v-pull-to-refresh>
    </div>
</v-container>
</template>

<style>
.scrollable-container {
  max-height: 300px;
  overflow-y: scroll;
}
</style>
