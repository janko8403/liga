<template>
    <div class="card">
        <div class="card-title p-2 px-4 pt-4">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <h3>Treść strony {{ content.name }}</h3>
                </div>
                <div class="col-md-4 cols-xs-12" style="text-align:right">
                    <button className="btn btn-light me-3" @click="cancelEditPage" v-if="!new_section">
                        Powrót
                    </button>
                    <button className="btn btn-light" @click="addSection" v-if="!new_section">
                        Nowa sekcja
                    </button>
                    <button className="btn btn-light" @click="cancelNewSection" v-if="new_section">
                        Anuluj
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row p-2" v-if="!new_section && !refresh_section">
                <template v-for="section in sections">
                    <CMSSection :section="section" @edit_section="refreshSections" @refresh_sections="refreshView"></CMSSection>
                </template>
            </div>
            <div class="row p-2" v-if="new_section">
                <CMSNewSections :menu_id="menu_id" @refresh_sections="refreshView"></CMSNewSections>
            </div>
        </div>
    </div>
</template>

<script>
import {nextTick, onMounted} from "vue";

import CMSSection from "./CMSSection";
import CMSNewSections from "./CMSNewSections";

import useSections from "../../../composables/backend/cms-sections";
import useCMSMenu from "../../../composables/backend/cms-menu";

export default {
    props: {
        menu_id: {
            required: true,
            type: Number,
        },
    },
    components: {
        CMSSection,
        CMSNewSections,
    },
    setup(props,{emit}) {
        const { sections, getSections } = useSections()
        const { content, getContent } = useCMSMenu()

        onMounted(() => getSections(props.menu_id))
        onMounted(() => getContent(props.menu_id))



        function cancelEditPage() {
            emit('menu_select_page',props.menu_id);
        }

        const refreshView = async () =>  {
            await getSections(props.menu_id);
            await nextTick()
            emit('refresh_sections',props.menu_id);
        }

        return {
            sections,
            refreshView,
            cancelEditPage,
            getSections,
            content,
        }
    },
    data() {
        return {
            new_section: false,
            refresh_section: false,
        }

    },
    methods: {
        addSection() {
            this.new_section = true;
        },
        cancelNewSection() {
            this.new_section = false;
        },
        refreshSections() {
            this.refresh_section = true;
            this.$nextTick(() => {
                this.refresh_section = false;
            })
        }
    }
}
</script>
