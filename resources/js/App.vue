<script setup>
import { RouterView, RouterLink } from 'vue-router'
import { ref } from 'vue';

const drawer = ref(false)

</script>

<template>
    <v-app>
        <v-app-bar color="primary">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title>
                Ayumi System
            </v-app-bar-title>
        </v-app-bar>

        <v-navigation-drawer permanennt v-model="drawer">
            <v-list-item to='/' title="ホーム"></v-list-item>
            <v-list-item to='/test' title="テスト"></v-list-item>
        </v-navigation-drawer>

        <v-main>
            <RouterView />
        </v-main>
    </v-app>
</template>
