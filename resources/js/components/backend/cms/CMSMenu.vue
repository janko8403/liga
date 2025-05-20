<template>
    <div class="row">
        <CMSMenuSelect @selected_menu="selectMenu"></CMSMenuSelect>
    </div>
    <div class="row justify-content-center mt-5" v-if="menu_id">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <CMSMenuTree :menuid="menu_id" @menu_select_page="editPage"></CMSMenuTree>
                    </div>
                </div>
            </div>
            <div class="col-9" v-if="current_page">
                <CMSMenuEdit v-if="!section_edit" :menu_id="current_page" @edit_section="editPageSections" @change_edited_page="closeEditedPage"></CMSMenuEdit>
                <CMSSections v-if="section_edit" :menu_id="current_page" @refresh_sections="editPageSections" @edit_section="editPageSections" @menu_select_page="editPage"></CMSSections>
            </div>
        </div>
    </div>
</template>

<script>

import CMSMenuTree from "./CMSMenuTree";
import CMSSections from "./CMSSections";
import CMSMenuEdit from "./CMSMenuEdit"
import CMSNewSections from "./CMSNewSections";
import {defineEmits, ref} from "vue";
import CMSMenuSelect from "./CMSMenuSelect";

export default {
    components: {
        CMSMenuSelect,
        CMSSections,
        CMSMenuTree,
        CMSMenuEdit,
        CMSNewSections
    },
    data() {
        return {
            menu_id: null,
            current_page: null,
            section_edit: null
        }
    },
    methods: {
        editPage(id) {
            this.current_page  = null;
            this.$nextTick(() =>
            {
                this.current_page = id;
                this.section_edit = null;
            });
        },
        selectMenu(id) {
            this.section_edit = null;
            this.current_page = null;
            this.menu_id = null;
            this.$nextTick(() =>
            {
                this.menu_id = id;
            });
        },
        editPageSections(id) {
            this.section_edit = 0;
            this.$nextTick(() =>
            {
                this.section_edit = id;
            });
        },
        closeEditedPage() {
            this.current_page= null;
            this.refreshTree();
        },
        refreshTree() {
            let c = this.menu_id;
            this.menu_id = null;
            this.$nextTick(() =>
            {
                this.menu_id = c;
            });
        },
    }

}
</script>
