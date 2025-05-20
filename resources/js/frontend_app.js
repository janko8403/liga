require('./bootstrap');

import { createApp,h } from "vue";
import frontend from './components/frontend/FrontendComponent.vue';
import frontMenu from './components/frontend/MenuComponent.vue';
import router from './frontend-router/frontend-router'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = createApp({
    components: {
        frontend
    },
    render: ()=>h(frontend)
}).use(router);
app.mount('#frontend_app');

const appmenu = createApp({
    components: {
        frontMenu
    },
    render: ()=>h(frontMenu)
}).use(router);
appmenu.mount('#menu_app');
