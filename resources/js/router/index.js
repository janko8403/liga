import { createRouter, createWebHistory } from 'vue-router'

import AdminsIndex from '../components/backend/admins/AdminIndex'
import AdminsEdit from '../components/backend/admins/AdminEdit'
import AdminsCreate from '../components/backend/admins/AdminCreate'

import UsersIndex from '../components/backend/users/UserIndex'
import UsersEdit from '../components/backend/users/UserEdit'
import ActivitiesIndex from '../components/backend/activities/ActivityIndex'
import ActivitiesEdit from '../components/backend/activities/ActivityEdit'
import ActivitiesCreate from '../components/backend/activities/ActivityCreate'

import CMSMenu from "../components/backend/cms/CMSMenu";
import CMSMenuTree from "../components/backend/cms/CMSMenuTree";
import ActivityEdition from "../components/backend/activities/ActivityEdition";
import DuelEditions from "../components/backend/duels/DuelEditions";
import DuelEditionEdit from "../components/backend/duels/DuelEditionEdit";
import SpecialTask from "../components/backend/activities/SpecialTask";
import Contest from "../components/backend/activities/Contest";
import Notifies from "../components/backend/notifies/Notifies";


const routes = [
    {
        path: '/backend/',
        alias: '/backend',
        name: 'backend',
        component: ActivitiesIndex,
        props: true,
    },
    {
        path: '/backend/admins',
        name: 'admins.index',
        component: AdminsIndex,
        props: true
    },
    {
        path: '/backend/admins/new',
        name: 'admins.create',
        component: AdminsCreate,
    },
    {
        path: '/backend/admins/:id/edit',
        name: 'admins.edit',
        component: AdminsEdit,
        props: true
    },
    {
        path: '/backend/agenci',
        name: 'users.index',
        component: UsersIndex,
        props: true
    },
    {
        path: '/backend/agenci/:id/edit',
        name: 'users.edit',
        component: UsersEdit,
        props: true
    },
    {
        path: '/backend/pojedynki',
        name: 'duels.index',
        component: DuelEditions,
    },
    {
        path: '/backend/pojedynki/:edition_id/edycja',
        name: 'duels.edit',
        component: DuelEditionEdit,
        props: true
    },
    {
        path: '/backend/aktywnosci',
        name: 'activities.index',
        component: ActivitiesIndex,
        props: true
    },
    {
        path: '/backend/aktywnosci/nowa',
        name: 'activities.create',
        component: ActivitiesCreate,
    },
    {
        path: '/backend/aktywnosci/:activity_id/edycje/:id',
        name: 'activities.editEdition',
        component: ActivityEdition,
        props: true
    },
    {
        path: '/backend/aktywnosci/:id/edycja',
        name: 'activities.edit',
        component: ActivitiesEdit,
        props: true
    },
    {
        path: '/backend/aktywnosci/zadania-specjalne/edycja/:id',
        name: 'activities.specialTasks',
        component: ActivityEdition,
        props: true
    },
    {
        path: '/backend/aktywnosci/zadania-specjalne/zadanie/:task_id',
        name: 'activities.specialTask',
        component: SpecialTask,
        props: true
    },
    {
        path: '/backend/aktywnosci/konkursy-i-akcje-sprzedazowe/zadanie/:contest_id',
        name: 'activities.contest',
        component: Contest,
        props: true
    },
    {
        path: '/backend/cms/',
        name: 'cmsmenu.index',
        component: CMSMenu,
    },
    {
        path: '/backend/cms/:id',
        name: 'cmsmenu.menuedit',
        component: CMSMenuTree,
        props: true
    },
    {
        path: '/backend/powiadomienia',
        name: 'notifies.index',
        component: Notifies,
        props: true
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})
