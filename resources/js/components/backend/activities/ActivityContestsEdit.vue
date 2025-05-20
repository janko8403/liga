<template>
    <div class="h3 mt-4 mb-3"><router-link :to="{ name: 'activities.index', }"><i class="fa-solid fa-chevron-left" style="color:#000"></i></router-link> Aktywności | <span class="text-muted h3 ml-1">{{ activity.name }}</span></div>
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
                        <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab" aria-controls="content" aria-selected="false">Konkursy</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab" aria-controls="permissions" aria-selected="false">Uprawnienia</button>
                    </li>
                </ul>
                <div class="tab-content" id="tabContent">
                    <div class="tab-pane fade p-2 active show" id="content" role="tabpanel" aria-labelledby="content-tab">
                        <Contests></Contests>
                    </div>
                    <div class="tab-pane fade p-2" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                        <h3 class="mt-3">Uprawnienia</h3>
                        <multiselect v-model="activity.permissions" :options="allPermissions"
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
                    <form class="row g-3" v-on:submit.prevent="saveActivity" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" v-bind:value="csrf">
                            <div class="col-12 mt-3">
                                <label for="name" class="form-label">Nazwa</label>
                                <input type="text" v-model="activity.name" class="form-control" id="name">
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="status" v-model="activity.status">
                                    <label class="form-check-label" for="status">Wyświetlanie na froncie strony</label>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="active_from" class="form-label">Początek aktywności</label>
                                <datepicker v-model="activity.active_from" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_from"/>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="active_from" class="form-label">Koniec aktywności</label>
                                <datepicker v-model="activity.active_to" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_to"/>
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
                    <img v-if="activity.header" :src="activity.header.file_path" style="width:100%">
                    <input type="file" name="header-file" class="form-control" @change="handleHeaderFileUpload( $event )" id="header-file"/>
                    <br>
                    <button v-on:click="submitHeaderFile()" class="btn btn-primary">Zapisz</button>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-title p-3">Załączniki</div>
                <div class="card-body">
                    <Files :activity_id="id" :file_type="file_type" activity_type="contests" />
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import useActivities from '../../../composables/backend/activities';
import useUsersPermissions from '../../../composables/backend/permissions';
import {useToast} from 'bootstrap-vue-3';
import {onMounted,ref} from 'vue';
import multiselect from 'vue-multiselect'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

import Files from '../files/FilesIndex'
import Contests from "./Contests";

export default {
    props: {
        id: {
            required: true,
            type: String,
        },
        activity: {

        }
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            file_type: 'attachment',
            header_file: '',
        }
    },
    components : {
        Datepicker,
        Files,
        multiselect,
        Contests,
    },
    setup(props) {
        const {errors, activity, updateActivity, getActivity} = useActivities()
        const { allPermissions, getAllPermissions } = useUsersPermissions()

        let toast = useToast()
        let showInfo = () => {
            toast.show({title: errors })
        }
        onMounted(() => getActivity(props.id))
        onMounted(() => getAllPermissions())

        const date = ref(new Date())

        const saveActivity = async () => {
            await updateActivity(props.id)
        }

        return {
            errors,
            activity,
            saveActivity,
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
            formData.append('activity_id', this.activity.id)
            formData.append('type', 'header')

            let response = axios.post('/api/backend/upload-header-file',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(response =>
            {
                this.errors = "Zapisano dane"
                this.showInfo()
            });

        },
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
