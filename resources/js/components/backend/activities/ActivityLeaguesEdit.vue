<template>
    <div class="h3 mt-4 mb-3"><router-link :to="{ name: 'activities.index' }"><i class="fa-solid fa-chevron-left" style="color:#000"></i></router-link> Aktywności | <span class="text-muted h3 ml-1">{{ activity.name }}</span></div>
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
                        <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="true">Ranking i dane</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab" aria-controls="permissions" aria-selected="false">Uprawnienia</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-2" id="data" role="tabpanel" aria-labelledby="data-tab">
                        <p>Dane</p>
                        <template v-if="activity.type == 1">
                            <select v-model="activity_type" class="form-control form-select form-select-sm col-3" @change="changeDataType($event)">
                                <option value="LeagueMSK">MSK</option>
                                <option value="LeagueDSK">DSK</option>
                                <option value="LeagueDWS">DWS</option>
                                <option value="LeagueMWP">MWP</option>
                                <option value="LeagueMWS">MWS</option>
                                <option value="LeagueRDSK">RDSK</option>
                                <option value="LeagueRKWP">RKWP</option>
                                <option value="LeagueRMWS">RMWS</option>
                            </select>
                        </template>
                        <template v-if="activity.type == 2">
                            <select v-model="activity_type" class="form-select form-select-sm col-3" @change="changeDataType($event)">
                                <option value="CASHLeagueMSK">MSK</option>
                                <option value="CASHLeagueDSK">DSK</option>
                            </select>
                        </template>
                        <template v-if="activity_type">
                            <ActivityDataImport :show_export="true" :type="activity_type" :show_import="true" :edition_id="0" :activity_id="activity.id"></ActivityDataImport>
                        </template>
                        <RankingTable v-if="showDataTable" :data="tableData" :columns="tableHeaders" :key="componentKey"></RankingTable>
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
                <div class="card-body">
                    <Files :activity_id="id" file_type="activity" />
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import useActivities from '../../../composables/backend/activities';
import useUsersPermissions from '../../../composables/backend/permissions';
import {useToast} from 'bootstrap-vue-3';
import {nextTick, onMounted, ref} from 'vue';
import multiselect from 'vue-multiselect'
import Datepicker from '@vuepic/vue-datepicker'
import RankingTable from '../elements/RankingTable'
import '@vuepic/vue-datepicker/dist/main.css'

import Files from '../files/FilesIndex'
import ActivityDataImport from "./ActivityDataImport";

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
        ActivityDataImport,
        RankingTable,
        Datepicker,
        Files,
        multiselect,
    },
    setup(props) {
        const { errors, activity, updateActivity, getActivity, showDataTable, tableData, tableHeaders, getLeagueActivityData } = useActivities()
        const { allPermissions, getAllPermissions } = useUsersPermissions()

        let componentKey = ref(0);
        let showLeagueData = ref(true)
        let activity_type = ref(null)
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

        const changeDataType = async (event) => {
            await getLeagueActivityData(event.target.value).then(() =>
            {
                activity_type = event.target.value;
            });
            componentKey += 1;
        }

        return {
            errors,
            activity,
            activity_type,
            showDataTable,
            tableHeaders,
            componentKey,
            tableData,
            changeDataType,
            showLeagueData,
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
                }).catch(result => {
                    this.errors = "Niepoprawny plik."
                    this.showInfo()
                    if (result.status === 422 && result.status === 400) {
                        for (const key in result.data.errors) {
                            this.errors += result.data.errors[key][0] + ' ';
                        }
                        this.showInfo()
                    }
                });
            } catch (e) {
                if (e.response && 419 === e.response.status) {
                    window.location.reload()
                }
                if (e.response.status === 422 && e.response.status === 400) {
                    for (const key in e.response.data.errors) {
                        this.errors += e.response.data.errors[key][0] + ' ';
                    }
                    this.showInfo()
                }
            }

        },
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
