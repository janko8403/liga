<template>
    <div class="h3 mb-3">
        <router-link :to="{ name: 'activities.editEdition', params: {id : task.edition_id, activity_id : '3' }}">
            <i class="fa-solid fa-chevron-left" style="color:#000"></i>
        </router-link>
        Zadania Specjalne
        <span class="text-muted h3 ml-1">Zadanie Opisowe</span>
    </div>
    <form class="row g-3" v-on:submit.prevent="saveSpecialTask">
    <div class="row mt-3">
        <div class="col-12 mt-3" style="margin-bottom:80px">
            <label for="active_from" class="form-label">Opis zadania</label>
            <Editor ref="ed1" v-if='activitySpecialTask.id' contentType="html" v-model:content="activitySpecialTask.description" theme="snow"></Editor>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 mt-3" style="margin-bottom:80px">
            <label for="active_from" class="form-label">Treść zadania</label>
            <Editor ref="ed2" v-if='activitySpecialTask.id' contentType="html" v-model:content="activitySpecialTask.task_description" theme="snow"></Editor>
        </div>
    </div>
    <div class="col-2 mt-3">
        <button type="submit"
                className="btn btn-primary">
            Zapisz
        </button>
    </div>
    </form>
</template>

<script>
import {useToast} from 'bootstrap-vue-3';
import {onMounted,ref} from 'vue';
import multiselect from 'vue-multiselect'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { QuillEditor as Editor } from '@vueup/vue-quill'

import Files from '../files/FilesIndex'
import useActivitySpecialTasks from "../../../composables/backend/activity-special-tasks";

export default {
    props: {
        task: {
            required: true,
        },
    },
    components : {
        Datepicker,
        Files,
        multiselect,
        Editor,
    },
    setup(props) {
        const ed1 = ref()
        const ed2 = ref()

        const { errors, activitySpecialTask, getActivitySpecialTask, updateActivitySpecialTaskDescription } = useActivitySpecialTasks()

        let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let toast = useToast()
        let showInfo = () => {
            toast.show({title: errors })
        }
        onMounted(() => getActivitySpecialTask(props.task.id))

        const date = ref(new Date())

        const saveSpecialTask = async () => {
            await updateActivitySpecialTaskDescription(props.task.id)
        }

        return {
            errors,
            csrf,
            ed1,
            ed2,
            activitySpecialTask,
            saveSpecialTask,
            date,
            showInfo,
        }
    },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
