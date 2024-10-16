<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    title: String,
})

</script>

<template>
    <div>
        <v-app-bar color="primary">
            <v-btn icon="mdi-arrow-left" @click="$router.back()"></v-btn>
            <v-app-bar-title>
                {{ title }}
            </v-app-bar-title>
        </v-app-bar>

        <v-main>
            <slot></slot>
        </v-main>
    </div>
</template>
