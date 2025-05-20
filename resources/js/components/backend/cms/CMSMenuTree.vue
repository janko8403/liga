<script>
import { Draggable } from "@he-tree/vue";
import "@he-tree/vue/style/default.css";
import { defineComponent, onMounted } from "vue";
import useMenus from "../../../composables/backend/cms-menu";

export default defineComponent({
    props: [
        'menuid',
    ],
    emits: [
        'menu_select_page'
    ],
    setup(props) {
        const { menus, storeMenu, getMenus } = useMenus()
        onMounted(() => getMenus(props.menuid))
        let menu_id = props.menuid
        let activeMenu = null;
        let hideAddButton = false;
        const newData = { parent_id: props.menuid, name: 'Nowa strona'}
        return {
            menus,
            activeMenu,
            storeMenu,
            getMenus,
            newData,
            hideAddButton,
            menu_id,
        }
    },
    components: { Draggable },
    methods: {
        editPage(id) {
            this.$emit('menu_select_page',id);
            this.activeMenu = id;
        },
        isActive(id) {
            return {
                active: id === this.activeMenu,
            }
        },
        add(data) {
            const newpage = this.storeMenu(data,this.menu_id)
            if (newpage>0 )
            {
                this.$emit('menu_select_page',newpage);
            }
        }
    }
});
</script>

<template>
    <div class="row mb-2">
        <div class="col-md-6 col-xs-12">
            <h3>Menu</h3>
        </div>
        <div class="col-md-6 col-xs-12 ms-auto">
            <div class="btn btn-light" v-if="!hideAddButton" @click="add(newData)">Dodaj nową stronę</div>
        </div>
    </div>
    <Draggable v-model="menus" ref="tree" style="height: 100%" :defaultOpen="false" :maxLevel="2" :indent="30" :watermark="false">
        <template #default="{ node, stat }" >
            <div class="menu-element-container" :class="isActive(node.id)">
                <div class="row">
                    <div class="col-11" @click="editPage(node.id)">
                        {{ node.text }}
                    </div>
                    <div class="col-1 ml-auto">
                        <span v-if="stat.children.length" @click="stat.open = !stat.open" class="menu-element-switch">
                            {{ stat.open ? "-" : "+" }}
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </Draggable>
</template>

<style></style>
