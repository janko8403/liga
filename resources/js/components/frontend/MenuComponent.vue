<template>
    <nav class="navbar navbar-expand-md">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/img/pzu-logo-front.png">
            </a>
            <div class="collapse navbar-collapse" id="navbarCollapseFrontend">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <template v-for="item in menus">
                        <li class="nav-item" v-if="item.submenus.length == 0">
                            <a class="nav-link" :href='"/"+item.slug'>{{item.name}}</a>
                        </li>
                        <li class="nav-item dropdown" v-if="item.submenus.length > 0">
                            <a class="nav-link dropdown-toggle" href="#" id="activity" data-bs-toggle="dropdown" aria-expanded="false">{{ item.name }}</a>
                            <ul class="dropdown-menu" aria-labelledby="activity">
                                <div class="dropdown-menu-arrow"></div>
                                <template v-for='subitem in item.submenus'>
                                    <li><a class="dropdown-item" :href='"/"+subitem.slug'>{{ subitem.name }}</a></li>
                                </template>
                            </ul>
                        </li>
                    </template>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer" data-bs-toggle="modal" data-bs-target="#kontakt">Kontakt</a>
                    </li>
                </ul>
                <ul class="navbar-nav me-right mb-2 mb-md-0">
                    <img v-if="user.photo" :src="user.photo.file_path" class="avatar">
                    <img src="/img/avatar.png" v-else>
                    <li class="nav-item">
                        <div class="login-item">
                            <div class="login-box">
                                <p class="login-name"><a href="/profil">{{ user.name }} {{ user.lastname}}</a></p>
                                <p class="session-time">Koniec sesji za:  <span><LogoutTimer></LogoutTimer></span></p>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-btn" href="https://zaloguj-pre.pzu.pl/wyloguj">WYLOGUJ SIĘ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</template>

<script>
import useCMSMenus from "../../composables/frontend/menu";
import {onMounted} from "vue";
import LogoutTimer from "./LogoutTimer";
import useCMS from "../../composables/frontend/cms";

export default {
    components: {LogoutTimer},

    setup() {
        const {user, getUserData} = useCMS()
        onMounted(() => getUserData())

        const { menus, getMenus } = useCMSMenus()
        onMounted(() => getMenus(1));
        return {
            menus,
            user,
        }
    },
    mounted() {
    }
}
</script>
