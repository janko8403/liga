<template>
    <div class="row justify-content-center mt-5">
        <div class="col-9">
            <div class="card p-4">
                <SpecialTaskDescriptive v-if='activitySpecialTask.type === "Zadanie Opisowe"' :task="activitySpecialTask"></SpecialTaskDescriptive>
                <SpecialTaskHomework v-if='activitySpecialTask.type === "Zadanie Domowe"' :task="activitySpecialTask"></SpecialTaskHomework>
                <SpecialTaskRanking v-if='activitySpecialTask.type === "Ranking"' :task="activitySpecialTask"></SpecialTaskRanking>
                <SpecialTaskQuiz v-if='activitySpecialTask.type === "Quiz"' :task="activitySpecialTask"></SpecialTaskQuiz>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <img v-if="activitySpecialTask.header" :src="activitySpecialTask.header.file_path" style="width:100%" class="mb-3">
                    <form class="row g-3" v-on:submit.prevent="saveActivitySpecialTask" enctype="multipart/form-data">
                        <nav class="navbar navbar-light bg-light justify-content-between p-3" style="overflow: hidden">
                            <a class="navbar-brand">{{ activitySpecialTask.name }}</a>
                        </nav>
                        <div class="row">
                            <input type="hidden" name="_token" v-bind:value="csrf">
                            <div class="col-12 mt-3">
                                <label for="name" class="form-label">Nazwa</label>
                                <input type="text" v-model="activitySpecialTask.name"  @input="genSlug" class="form-control" id="name">
                            </div>
                            <div class="col-12 mt-3">
                                <label for="name" class="form-label" title="Unikalna nazwa strony określana do zbudowania adresu URL">Slug</label>
                                <input type="text" v-model="activitySpecialTask.slug" class="form-control" id="slug">
                            </div>
                            <div class="col-12 mt-3">
                                <label for="active_from" class="form-label">Początek zadania</label>
                                <datepicker v-model="activitySpecialTask.active_from" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_from"/>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="active_from" class="form-label">Koniec zadania</label>
                                <datepicker v-model="activitySpecialTask.active_to" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_to"/>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="status" v-model="activitySpecialTask.status">
                                    <label class="form-check-label" for="status">Status</label>
                                </div>
                            </div>
                            <div class="col-12 mt-3" v-if='activitySpecialTask.type === "Quiz"'>
                                <div class="col-12 mt-3">
                                    <label for="name" class="form-label">Maksymalny czas (sekundy)</label>
                                    <input type="number" v-model="activitySpecialTask.quiz_time" class="form-control" id="name" style="width:50%;">
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="quiz-ranking-points" class="form-label">Punkty za miejsca w rankingu</label>
                                    <input type="number" v-model="activitySpecialTask.quiz_ranking_points" class="form-control" id="quiz-ranking-points">
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="quiz-percentage-points" class="form-label">Punkty za procent poprawności</label>
                                    <input type="number" v-model="activitySpecialTask.quiz_percentage_points" class="form-control" id="quiz-percentage-points">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="mt-3">Uprawnienia</label>
                                <multiselect v-model="activitySpecialTask.permissions" :options="allPermissions"
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
                                <button type="submit" className="btn btn-primary">
                                    Zapisz
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <img v-if="activitySpecialTask.header" :src="activitySpecialTask.header.file_path" style="width:100%">
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
                    <Files v-if="activitySpecialTask.id>0" :file_type="file_type" :activity_id="activitySpecialTask.id"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SpecialTaskDescriptive from "./SpecialTaskDescriptive";
import SpecialTaskHomework from "./SpecialTaskHomework";
import SpecialTaskQuiz from "./SpecialTaskQuiz";
import SpecialTaskRanking from "./SpecialTaskRanking";
import useActivitySpecialTasks from "../../../composables/backend/activity-special-tasks";
import {nextTick, onMounted} from "vue";
import multiselect from 'vue-multiselect'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import Files from '../files/FilesIndex'
import useUsersPermissions from "../../../composables/backend/permissions";
import {useToast} from "bootstrap-vue-3";

export default {
    props: {
        task_id: {
            required: true,
        },
    },
    setup(props) {
        const { activitySpecialTask, getActivitySpecialTask, updateActivitySpecialTask } = useActivitySpecialTasks()
        const { allPermissions, getAllPermissions } = useUsersPermissions()

        onMounted(() => getAllPermissions())
        onMounted(() => getActivitySpecialTask(props.task_id))

        let toast = useToast()
        let showNotify = (info) => {
            toast.show({title: info })
        }

        const saveActivitySpecialTask = async () => {
            await updateActivitySpecialTask(props.task_id)
        }

        return {
            activitySpecialTask,
            saveActivitySpecialTask,
            allPermissions,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            file_type: 'special-task',
            showNotify,
        }
    },
    components: {
        SpecialTaskDescriptive,
        SpecialTaskHomework,
        SpecialTaskQuiz,
        SpecialTaskRanking,
        Files,
        Datepicker,
        multiselect,
    },
    methods: {
        handleHeaderFileUpload(event) {
            this.file = event.target.files[0];
        },
        submitHeaderFile() {
            let formData = new FormData();
            formData.append('header-file', this.file);
            formData.append('activity_id', this.task_id)
            formData.append('type', 'special-task-header')

            let response = axios.post('/api/backend/upload-header-file',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(() =>
            {
                this.showNotify("Zapisano grafikę")
            });

        },
        genSlug() {
            var str = this.activitySpecialTask.name;
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

            this.activitySpecialTask.slug = str;
        },
    },
}
</script>

