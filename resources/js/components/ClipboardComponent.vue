<script setup>
import { defineProps } from 'vue';
import { copyText } from '@lxf2513/vue3-clipboard'

const props = defineProps({
    url: {
        type: String,
        required: true
    }
})

const click = async () => {
    console.log(props.url)
    copyText(props.url)
}
</script>

<template>
    <v-icon
        icon="mdi-content-copy"
        @click="click"
    ></v-icon>
</template>
