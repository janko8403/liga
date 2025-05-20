<template>
    <div class="card">
        <div class="card-body">
            <img v-if="duelConfig.header" :src="duelConfig.header.file_path" style="width:100%" class="mb-3">
            <form class="row g-3" v-on:submit.prevent="saveDuelConfig" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" name="_token" v-bind:value="csrf">
                    <div class="col-12 mt-3">
                        <label for="name" class="form-label">Nazwa</label>
                        <input type="text" v-model="duelConfig.name" class="form-control" id="name">
                    </div>
                    <div class="col-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" v-model="duelConfig.status">
                            <label class="form-check-label" for="status">Wyświetlanie na froncie strony</label>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="active_from" class="form-label">Początek aktywności</label>
                        <datepicker v-model="duelConfig.active_from" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_from"/>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="active_from" class="form-label">Koniec aktywności</label>
                        <datepicker v-model="duelConfig.active_to" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_to"/>
                    </div>
                    <div class="col-12 mt-3">
                        <label class="mt-3">Uprawnienia</label>
                        <multiselect v-model="duelConfig.permissions" :options="allPermissions"
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
            </form>
        </div>
    </div>
    <div class="card mt-4">
        <img v-if="duelConfig.header" :src="duelConfig.header.file_path" style="width:100%">
        <div class="card-title p-3">Zmień obraz nagłówka</div>
        <div class="card-body">
            <input type="file" name="header-file" class="form-control" @change="handleHeaderFileUpload( $event )" id="header-file"/>
            <br>
            <button v-on:click="submitHeaderFile()" class="btn btn-primary">Zapisz</button>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-title p-3">Załączniki</div>
        <div class="card-body">
            <Files :file_type="file_type" :activity_id="duelConfig.id"/>
        </div>
    </div>
</template>

<script>
import useUsersPermissions from '../../../composables/backend/permissions';
import {useToast} from 'bootstrap-vue-3';
import {nextTick, onMounted, ref} from 'vue';
import multiselect from 'vue-multiselect'
import Datepicker from '@vuepic/vue-datepicker'
import RankingTable from '../elements/RankingTable'
import '@vuepic/vue-datepicker/dist/main.css'

import Files from '../files/FilesIndex'
import ActivityDataImport from "../activities/ActivityDataImport";
import useDuelsConfig from "../../../composables/backend/duels-config";

export default {
    props: {
        edition_id: {
            required: false,
        }
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            file_type: 'duel-activity-attachment',
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
        const { errors, duelConfig, updateDuelConfig, getDuelConfig  } = useDuelsConfig()
        const { allPermissions, getAllPermissions } = useUsersPermissions()

        let toast = useToast()
        let showInfo = () => {
            toast.show({title: errors })
        }

        onMounted(() => getDuelConfig("1"))
        onMounted(() => getAllPermissions())

        const date = ref(new Date())

        const saveDuelConfig = async () => {
            await updateDuelConfig('1')
            await nextTick()
            await getDuelConfig('1')
        }

        return {
            errors,
            duelConfig,
            saveDuelConfig,
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
            formData.append('activity_id', 1);
            formData.append('type', 'duels-header');


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
<style src="../../../../../node_modules/vue-multiselect/dist/vue-multiselect.css"></style>
