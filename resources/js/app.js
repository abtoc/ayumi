import './bootstrap';
import '../css/app.css';

// Vue
import {createApp} from 'vue';
import App from './App.vue';

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'

// pinia
import { createPinia } from 'pinia';

// Router
import router from './router';


const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "mdi",
    },
})

createApp(App)
    .use(createPinia())
    .use(router)
    .use(vuetify)
    .mount('#app')
