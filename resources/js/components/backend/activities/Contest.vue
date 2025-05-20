<template>
    <div class="h3 mb-2">
        <router-link :to="{ name: 'activities.edit', params: { id: 4 } }">
            <i class="fa-solid fa-chevron-left" style="color:#000"></i>
        </router-link>
        Konkursy i Akcje Sprzedażowe |
        <span class="text-muted h3 ml-1">
            <template v-if='contest.type === "Konkurs"'>Konkurs</template>
            <template v-if='contest.type === "Akcja Sprzedażowa"'>Akcja Sprzedażowa</template>
              {{ contest.name }}
        </span>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-8">
            <div class="col-12">
                <form class="row g-3" v-on:submit.prevent="saveContest" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="_token" v-bind:value="csrf">
                                <div class="col-12 mt-3">
                                    <label for="name" class="form-label">Nazwa</label>
                                    <input type="text" v-model="contest.name" class="form-control" id="name">
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="name" class="form-label">Status</label>
                                    <div class="form-check form-switch pointer">
                                        <input class="form-check-input" type="checkbox" id="status" v-model="contest.status">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="type" class="form-label">Typ zadania</label>
                                    <select v-model="contest.type" class="form-control">
                                        <option value="Konkurs">Konkurs</option>
                                        <option value="Akcja Sprzedażowa">Akcja Sprzedażowa</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="active_from" class="form-label">Aktywne od</label>
                                    <datepicker v-model="contest.active_from" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_from"/>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="active_from" class="form-label">Aktywne do</label>
                                    <datepicker v-model="contest.active_to" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_to"/>
                                </div>
                                <div class="col-12 mt-3" style="margin-bottom:80px">
                                    <label for="active_from" class="form-label">Opis aktywności</label>
                                    <editor ref="ed1" v-if='contest.id' contentType="html" v-model:content="contest.description_before" theme="snow"></editor>
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="mt-3">Uprawnienia</label>
                                    <multiselect v-model="contest.permissions" :options="allPermissions"
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
                                <div class="col-2 mt-3">
                                    <button type="submit"
                                            className="btn btn-primary">
                                        Zapisz
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <ActivityDataImport :show_export="true" type="contest" :show_import="true" :edition_id="contest.id" :activity_id="4"></ActivityDataImport>
                </div>
            </div>
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-title p-3">Zmień obraz nagłówka</div>
                    <img v-if="contest.header" :src="contest.header.file_path" style="width:100%">
                    <div class="card-body">
                        <input type="file" name="header-file" class="form-control" @change="handleHeaderFileUpload( $event )" id="header-file"/>
                        <br>
                        <button v-on:click="submitHeaderFile()" class="btn btn-primary">Zapisz</button>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-title p-3">Załączniki</div>
                    <div class="card-body">
                        <Files v-if="contest.id" file_type="contest" :activity_id="contest.id"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref, nextTick, onMounted} from "vue";
import useContests from "../../../composables/backend/contest";
import Files from '../files/FilesIndex'
import multiselect from 'vue-multiselect'
import Datepicker from '@vuepic/vue-datepicker'
import useUsersPermissions from '../../../composables/backend/permissions';
import {useToast} from "bootstrap-vue-3";
import ActivityDataImport from "./ActivityDataImport";
import { QuillEditor as Editor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    props: {
        contest_id: {
            required: true,
        },
    },
    components: {
        Files,
        multiselect,
        Datepicker,
        Editor,
        ActivityDataImport,
    },
    setup(props) {
        const ed1 = ref()
        const ed2 = ref()

        const { errors,contest, updateContest, getContest } = useContests()
        onMounted(() => getContest(props.contest_id))
        const { allPermissions, getAllPermissions } = useUsersPermissions()

        let toast = useToast()
        let showInfo = () => {
            toast.show({title: errors })
        }
        let showNotify = (info) => {
            toast.show({title: info })
        }
        onMounted(() => getAllPermissions())

        const saveContest = async () => {
            await updateContest(props.contest_id)
        }

        return {
            contest,
            errors,
            allPermissions,
            ed1,
            ed2,
            getContest,
            showInfo,
            saveContest,
            file_type: 'contest',
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            header_file: '',
        }
    },
    methods: {
        handleHeaderFileUpload(event) {
            this.file = event.target.files[0];
        },
        submitHeaderFile() {
            let formData = new FormData();
            formData.append('header-file', this.file);
            formData.append('activity_id', this.contest_id)
            formData.append('type', 'contest-header')

            try {
                let response = axios.post('/api/backend/upload-header-file',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    this.errors = "Zapisano dane"
                    this.showInfo()
                    this.getContest(this.contest_id)
                });
            } catch (e) {
                if (e.response.status === 422) {
                    errors.value = e.response.data.errors + ' ';
                }
                showInfo(errors.value);
            }

        },
    },
}
</script>
