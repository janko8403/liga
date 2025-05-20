<template>
    <div class="h3 mt-4 mb-3">
        <router-link :to="{ name: 'activities.edit', params: { id: activity_id } }">
            <i class="fa-solid fa-chevron-left" style="color:#000"></i>
        </router-link>
        Aktywność Zadania Specjalne | <span class="text-muted h3 ml-1">Edycja {{ activityEdition.name }}</span></div>
    <div class="row justify-content-center mt-3">
        <div class="col-12">
            <div class="card-body">
                <div class="row">
                    <div className="mt-2 mb-6 text-sm text-red-600" v-if="errors !== ''">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card p-4">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link " id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="true">Ranking</button>
                    </li>
                    <li class="nav-item" role="presentation" v-if="activityEdition.activity_id === 3">
                        <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab" aria-controls="content" aria-selected="false">Zadania</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab" aria-controls="permissions" aria-selected="false">Uprawnienia</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade p-2" id="data" role="tabpanel" aria-labelledby="data-tab" style="width:100%">
                        <RankingTable :data="data" :columns="columns"></RankingTable>
                    </div>
                    <div class="tab-pane fade show active p-2" id="content" role="tabpanel" v-if="activityEdition.activity_id === 3" aria-labelledby="content-tab">
                        <SpecialTasks :edition_id="id"></SpecialTasks>
                    </div>
                    <div class="tab-pane fade p-2" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                        <h3 class="mt-3">Uprawnienia</h3>
                        <multiselect v-model="activityEdition.permissions" :options="allPermissions"
                                     label="name"
                                     track-by="id"
                                     :multiple="true"
                                     selectLabel="Wybierz"
                                     selectedLabel="Wybrano"
                                     deselect-label="Usuń"
                                     placeholder="Wybierz"
                                     :close-on-select="false"
                                     :clear-on-select="false">
                        </multiselect>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3" v-on:submit.prevent="saveActivityEdition" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" v-bind:value="csrf">
                            <div class="col-12 mt-3">
                                <label for="name" class="form-label">Nazwa</label>
                                <input type="text" v-model="activityEdition.name" @input="genSlug" class="form-control" id="name">
                            </div>
                            <div class="col-12 mt-3">
                                <label for="name" class="form-label" title="Unikalna nazwa strony określana do zbudowania adresu URL">Slug</label>
                                <input type="text" v-model="activityEdition.slug" class="form-control" id="slug">
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="status" v-model="activityEdition.status">
                                    <label class="form-check-label" title="Edycja jest wyświetlania na stronie" for="status">Front strony</label>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="active_from" class="form-label">Początek edycji</label>
                                <datepicker v-model="activityEdition.active_from" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_from"/>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="active_from" class="form-label">Koniec edycji</label>
                                <datepicker v-model="activityEdition.active_to" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_to"/>
                            </div>
                            <div class="col-12 mt-3">

                            </div>
                            <div class="col-2 mt-3">
                                <button type="submit"
                                        className="btn btn-primary">
                                    Zapisz
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-title p-3">Obraz nagłówka</div>
                <div class="card-body">
                    <img v-if="activityEdition.header" :src="activityEdition.header.file_path" style="width:100%">
                    <input type="file" name="edition-header-file" class="form-control" @change="handleHeaderFileUpload( $event )" id="header-file"/>
                    <br>
                    <button v-on:click="submitHeaderFile()" class="btn btn-primary">Zapisz</button>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-title p-3">Załączniki</div>
                <div class="card-body">
                    <Files :activity_id="id" :file_type="file_type" activity_type="activity_edition" />
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import useUsersPermissions from '../../../composables/backend/permissions';
import {useToast} from 'bootstrap-vue-3';
import {onMounted,ref} from 'vue';
import multiselect from 'vue-multiselect'
import Datepicker from '@vuepic/vue-datepicker'
import RankingTable from '../elements/RankingTable'
import '@vuepic/vue-datepicker/dist/main.css'

import Files from '../files/FilesIndex'
import useActivityEditions from "../../../composables/backend/activities-editions";
import SpecialTasks from "./SpecialTasks";

export default {
    props: {
        id: {
            required: true,
        },
        activity_id: {
            required: true,
        },
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            file_type: 'edition-attachment',
            header_file: '',
            data: [],
            columns: ['MSK','DSK','Wynik']
        }
    },
    components : {
        SpecialTasks,
        Datepicker,
        Files,
        multiselect,
        RankingTable,
    },
    setup(props) {
        const { errors, activityEdition, updateActivityEdition, getActivityEdition } = useActivityEditions()
        const { allPermissions, getAllPermissions } = useUsersPermissions()

        let toast = useToast()
        let showInfo = () => {
            toast.show({title: errors })
        }
        onMounted(() => getActivityEdition(props.id))
        onMounted(() => getAllPermissions())

        const date = ref(new Date())

        const saveActivityEdition = async () => {
            await updateActivityEdition(props.id)
        }

        return {
            errors,
            activityEdition,
            saveActivityEdition,
            getAllPermissions,
            allPermissions,
            date,
            showInfo,
        }
    },
    methods: {
        handleHeaderFileUpload(event) {
            this.file = event.target.files[0];
        },
        submitHeaderFile() {
            let formData = new FormData();
            formData.append('header-file', this.file);
            formData.append('activity_id', this.id)
            formData.append('type', 'activity-edition-header')

            let response = axios.post('/api/backend/upload-header-file',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(response =>
            {
                this.activityEdition.header.file_path = response.data;
                this.errors = "Zapisano dane"
                this.showInfo()
            });

        },
        genSlug() {
            var str = this.activityEdition.name;
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

            this.activityEdition.slug = str;
        },
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
