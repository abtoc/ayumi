<script setup>
import { defineProps, ref } from 'vue';

const props = defineProps({
    title: String,
})

const drawer = ref(false)

</script>

<template>
    <div>
        <v-app-bar color="primary">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title>
                {{ title }}
            </v-app-bar-title>
        </v-app-bar>

        <v-navigation-drawer permanennt v-model="drawer">
            <slot name="navigation"></slot>
        </v-navigation-drawer>

        <v-main>
            <slot></slot>
        </v-main>
    </div>
</template>
