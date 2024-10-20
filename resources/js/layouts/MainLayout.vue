<script setup>
import { defineProps, ref } from 'vue';
import { useNavigationState } from '../stores/NavigationState';

const nav = useNavigationState()

const props = defineProps({
    title: String,
})

const drawer = ref(false)

</script>

<template>
    <div>
        <v-app-bar color="primary">
            <v-app-bar-nav-icon @click="nav.toggle()"></v-app-bar-nav-icon>
            <v-app-bar-title>
                {{ title }}
            </v-app-bar-title>
        </v-app-bar>

        <v-navigation-drawer permanennt v-model="nav.drawer">
            <slot name="navigation"></slot>
        </v-navigation-drawer>

        <v-main style="--v-layout-top: 72px;">
            <slot></slot>
        </v-main>
    </div>
</template>
