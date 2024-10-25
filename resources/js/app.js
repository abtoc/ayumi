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

// OneSignal
import OneSignalVuePlugin from '@onesignal/onesignal-vue3';

// Clipboard
import { VueClipboard } from '@lxf2513/vue3-clipboard';


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
    .use(OneSignalVuePlugin, {
        appId: 'f2758b34-e545-462b-bb9d-18b9fb8eecb6',
        safari_web_id: 'web.onesignal.auto.2b9eaa60-5747-4249-a27c-f48aa9ddca65',
        notifyButton: {
            enable: true,
        },
    })
    .use(VueClipboard)
    .mount('#app')
