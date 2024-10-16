<script setup>
import { RouterView, RouterLink } from 'vue-router';
import LoginView from './pages/LoginView.vue';

</script>

<template>
    <v-app>
        <RouterView />
         <LoginView />
    </v-app>
</template>
