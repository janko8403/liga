<template>
    <div class="h3 mb-3">
        <router-link :to="{ name: 'activities.editEdition', params: {id : task.edition_id, activity_id : '3' }}">
            <i class="fa-solid fa-chevron-left" style="color:#000"></i>
        </router-link>
        <span class="text-muted h3 ml-1"> Zadanie Domowe</span>
        <form class="row g-3" v-on:submit.prevent="saveSpecialTask">
        <div class="col-12 mt-5" style="margin-bottom:80px">
            <label class="form-label">Opis zadania</label>
            <editor ref="ed1" v-if='activitySpecialTask.id' contentType="html" v-model:content="activitySpecialTask.description" theme="snow"></editor>
        </div>
        <div class="row mt-3">
            <div class="col-12 mt-3" style="margin-bottom:80px">
                <label for="active_from" class="form-label">Treść zadania</label>
                <Editor ref="ed2" v-if='activitySpecialTask.id' contentType="html" v-model:content="activitySpecialTask.task_description" theme="snow"></Editor>
            </div>
        </div>
        <div class="col-2 mt-4">
            <button type="submit"
                    className="btn btn-primary">
                Zapisz
            </button>
        </div>
        </form>
    </div>
</template>

<script>
import {useToast} from 'bootstrap-vue-3';
import {nextTick, onMounted, ref} from 'vue';
import { QuillEditor as Editor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import useHomework from "../../../composables/backend/homework";
import useActivitySpecialTasks from "../../../composables/backend/activity-special-tasks";

export default {
    props: {
        task: {
            required: true,
        },
    },
    components : {
        Editor,
    },
    setup(props) {
        const { errors, activitySpecialTask, getActivitySpecialTask, updateActivitySpecialTaskDescription } = useActivitySpecialTasks()
        const ed1 = ref()
        const ed2 = ref()

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
            activitySpecialTask,
            ed1,
            ed2,
            saveSpecialTask,
            date,
            showInfo,
        }
    },
}
</script>
