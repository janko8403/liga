<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
        <a class="navbar-brand" href="#">Nowe zadanie</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button class="btn btn-secondary me-2" @click='addTask("Ranking");'>Ranking</button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-secondary me-2" @click='addTask("Quiz");'>Quiz</button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-secondary me-2" @click='addTask("Zadanie Opisowe");'>Zadanie opisowe</button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-secondary" @click='addTask("Zadanie Domowe");'>Zadanie domowe</button>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row mt-3">
        <div class="col-3" v-for="item in activitySpecialTasks" :key="item.id">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ item.name }}</h5>
                    <span class="text-muted">{{ item.type }}</span>
                    <p class="card-text">
                        <small class="text-muted" v-if="item.active_from!='1970-01-01' && item.active_to!='1970-01-01'">{{ item.active_from }} - {{ item.active_to }}</small>
                    </p>
                    <router-link :to="{ name: 'activities.specialTask', params: { task_id: item.id } }"
                                 class="mr-2 btn btn-m">
                        Edycja
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useActivitySpecialTasks from '../../../composables/backend/activity-special-tasks'
import {nextTick, onMounted} from 'vue';

export default {
    props: {
        edition_id: {
            required: true,
            type: String,
        },
    },
    setup(props) {
        const { activitySpecialTasks, getActivitySpecialTasks, addSpecialTasksEditionTask } = useActivitySpecialTasks()
        onMounted(() => getActivitySpecialTasks(props.edition_id))

        const addTask = async (task_type) => {
            await addSpecialTasksEditionTask(props.edition_id, task_type);
            await nextTick();
            await getActivitySpecialTasks(props.edition_id);
        }
        return {
            activitySpecialTasks,
            addTask,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    data() {
        return {
            file_type: 'edition-attachment',
            header_file: '',
            data: [],
        }
    },
}
</script>
