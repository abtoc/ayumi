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

// Router
import router from './router';

// pinia
import { createPinia } from 'pinia';

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "mdi",
    },
})

createApp(App)
    .use(router)
    .use(vuetify)
    .use(createPinia())
    .mount('#app')

/*
import { useLoginState } from './stores/LoginState';

router.beforeEach((to) => {
    const st = useLoginState()

    if(['login'].includes(to.name)){
        return true
    }

    if(st.loggedin){
        return true
    }
    return { name: 'login' }
})
*/
