<template>
    <form class="row g-3" v-on:submit.prevent="saveMenuDetails" enctype="multipart/form-data">
    <div class="card">
        <div class="card-title p-2 px-2 pt-4">
            <h3>Edycja strony {{ content.name }}</h3>
        </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-8 col-xs-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nazwa strony</label>
                            <input type="text" v-model="content.name" class="form-control" @input="genSlug" id="name" aria-describedby="nameHelp">
                            <div id="nameHelp" class="form-text">Wyświetlana nazwa elementu w menu</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Slug</label>
                            <input type="text" v-model="content.slug" class="form-control" id="slug">
                        </div>
                    </div>

                    <div class="col-md-12 col-xs-12">
                        <label for="pselect" class="form-label">Uprawnienia</label>
                        <multiselect id="pselect" v-model="content.permissions" :options="allPermissions"
                                     label="name"
                                     track-by="id"
                                     :multiple="true"
                                     selectLabel="Wybierz"
                                     selectedLabel="Wybrano"
                                     deselect-label="Usuń"
                                     placeholder="Wybierz"
                                     :close-on-select="false"
                                     :clear-on-select="false" aria-describedby="permissionsHelp">
                        </multiselect>
                        <div id="permissionsHelp" class="form-text">Strona będzie widoczna dla wybranych grup użytkowników</div>
                    </div>
                    <div class="col-md-6 col-xs-12 mt-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" v-model="content.published">
                            <label class="form-check-label" for="status">Wyświetlanie na froncie strony</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12" style="text-align:right">
                        <div className="btn btn-ligh" style="margin-right: 20px;" v-if="content.deletable === 1" @click="deletePage">
                            <i class="fa fa-trash" style="color:red" title="Usuń całą sekcję"></i>
                        </div>
                        <button type="submit"
                                className="btn btn-primary me-3">
                            Zapisz
                        </button>
                    </div>
                </div>
                <hr class="mt-3">
                <div class="row mt-3">
                    <div class="col-md-6 col-xs-12">
                        Treść strony
                    </div>
                    <div class="col-md-6 col-xs-12" style="text-align:right">
                        <button className="btn btn-primary" @click="editSection">
                            Edytuj
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
import { onMounted, defineEmits } from "vue";
import useCMSMenu from "../../../composables/backend/cms-menu";
import multiselect from "vue-multiselect";
import useUsersPermissions from "../../../composables/backend/permissions";
import {useToast} from 'bootstrap-vue-3';

export default {
    props: {
        menu_id: {
            required: true,
            type: Number,
        },
    },
    components: {
        multiselect,
    },
    emits: [
        'edit_section',
        'change_edited_page'
    ],
    setup(props,{emit}) {
        const { messages, content, destroyContent, updateContent, getContent } = useCMSMenu()
        const { allPermissions, getAllPermissions } = useUsersPermissions()

        function editSection(id) {
            emit('edit_section',id);
        }

        function deletePage() {
            if (confirm("Czy na pewno usunąć całą stronę?")) {
                destroyContent(props.menu_id);
                emit('change_edited_page', null);
            }
        }

        onMounted(() => getContent(props.menu_id))
        onMounted(() => getAllPermissions())

        let toast = useToast()
        let showInfo = () => {
            toast.show({title: messages })
        }
        const saveMenuDetails = async () => {
            await updateContent(props.menu_id);
            showInfo();
        };

        return {
            content,
            messages,
            allPermissions,
            saveMenuDetails,
            deletePage,
            showInfo,
            editSection
        }
    },
    methods: {
         genSlug() {
            var str = this.content.name;
            str = str.replace(/^\s+|\s+$/g, '');
            str = str.toLowerCase();
            var from = "ąàáäâćęèéëêłżźśìíïîòóöôùúüûñç·/_,:;";
            var to   = "aaaaaceeeeelzzsiiiioooouuuunc------";

            for (var i=0, l=from.length ; i<l ; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }
            str = str.replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            this.content.slug = str;
        },
    }
}
</script>
