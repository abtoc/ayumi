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

        <v-main style="--v-layout-top: 72px;">
            <slot></slot>
        </v-main>

        <v-bottom-navigation>
            <slot name="bottom-navigation"></slot>
        </v-bottom-navigation>
    </div>
</template>
