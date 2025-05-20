import { createRouter, createWebHistory } from 'vue-router'

import UserEdit from '../components/frontend/user/UserEdit'
import UserRegister from '../components/frontend/user/UserRegister'
import UserRegisterFinish from '../components/frontend/user/UserRegisterFinish'
import FrontendCMS from "../components/frontend/FrontendCMS";

import error404 from "../components/frontend/errors/404";

const routes = [

    {
        path: '/',
        name: 'main.index',
        component: FrontendCMS,
        props: { slug: 'strona-glowna' }
    },
    {
        path: '/zadania-specjalne/:taskslug',
        name: 'specialtask.task',
        component: FrontendCMS,
        props: true
    },
    {
        path: '/konkursy-i-akcje-sprzedazowe/:contest_id',
        name: 'contests.contest',
        component: FrontendCMS,
        props: true
    },
    {
        path: '/profil',
        name: 'user.edit',
        component: UserEdit,
        props: true
    },
    {
        path: '/error/404',
        name: 'notfound',
        component: error404
    },
    {
        path: '/:slug',
        name: 'main.cms',
        component: FrontendCMS,
        props: true
    }

];

export default createRouter({
    history: createWebHistory(),
    routes
})
