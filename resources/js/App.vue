<script setup>
import { RouterView, RouterLink } from 'vue-router'
import { ref } from 'vue';

const drawer = ref(false)

</script>

<template>
    <v-app>
        <v-system-bar color="secondary">
            System Bar
        </v-system-bar>

        <v-app-bar color="primary">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title>
                Application Bar
            </v-app-bar-title>
        </v-app-bar>

        <v-navigation-drawer permanennt v-model="drawer">
            Navigation Drawer
        </v-navigation-drawer>

        <v-main>
            <RouterView />
        </v-main>
    </v-app>
</template>
