<script setup>
import { ref, onMounted } from 'vue';

const user_id = ref('')

onMounted(() => {

})

</script>

<template>
<v-container>
    <v-table>
        <tbody>
            <tr>
                <td>OneSignalユーザID</td>
                <td>{{ user_id }}</td>
            </tr>
        </tbody>
    </v-table>
</v-container>
</template>
