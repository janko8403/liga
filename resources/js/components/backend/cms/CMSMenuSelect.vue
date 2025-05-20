<template>
    <div class="row justify-content-center mt-1">
        <div class="col-12">
            <div class="row">
                <div class="p-3 bg-light col-3" v-for="menu in mainMenus">
                   <div class="card p-3 text-black dp__pointer"  @click="setMenu(menu.id)">{{ menu.name }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useCMSMenu from '../../../composables/backend/cms-menu.js'
import { onMounted } from 'vue';

export default {
    setup(props,{emit}) {
        const { mainMenus, getMainMenus }  = useCMSMenu()
        onMounted(getMainMenus)
        function setMenu(id) {
            emit('selected_menu',id);
        }
        return {
            mainMenus,
            setMenu,
        }
    },
}
</script>
