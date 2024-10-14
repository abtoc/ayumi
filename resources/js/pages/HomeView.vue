<script setup>
import { ref } from 'vue';
import VisitComponent from '../components/VisitComponent.vue';
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
    console.log('visit loading')
    await new Promise(resolve => setTimeout(() => resolve(), 2000))
    renderKey.value = renderKey.value + 1
    console.log('visit load finish')
    done('ok')
}

</script>

<template>
<v-container>
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
