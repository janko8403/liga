import frontMenu from "./components/frontend/MenuComponent";

require('./bootstrap');
require('moment');
import { createApp,h } from "vue";
import backend from './components/backend/BackendComponent.vue';
import BootstrapVue3 from 'bootstrap-vue-3'
import router from './router'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'
import {BToastPlugin} from 'bootstrap-vue-3'
import BackendLogoutTimer from "./components/backend/BackendLogoutTimer";

const app = createApp({
    components: {
        backend,
    },
    render: ()=>h(backend)
});

app.use(router);
app.use(BootstrapVue3)
app.use(BToastPlugin)
app.mount('#backend_app');

const applogout = createApp({
    components: {
        BackendLogoutTimer,
    },
    render: ()=>h(BackendLogoutTimer)
});
applogout.mount('#logout_app');
