import { ref } from 'vue'
import axios from 'axios'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

function dateFormat(inputDate, format) {
    const date = new Date(inputDate);

    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    format = format.replace("MM", month.toString().padStart(2,"0"));

    if (format.indexOf("yyyy") > -1) {
        format = format.replace("yyyy", year.toString());
    } else if (format.indexOf("yy") > -1) {
        format = format.replace("yy", year.toString().substr(2,2));
    }
    format = format.replace("dd", day.toString().padStart(2,"0"));

    return format;
}

export default function useActivitySpecialTasks() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const activitySpecialTask = ref([])
    const activitySpecialTasks = ref([])

    const ranking = ref([])

    const homework = ref([])
    const descriptive = ref([])

    const errors = ref('')

    const getActivitySpecialTasks = async (id) => {
        let response = await axios.get(`/api/backend/activities/tasks/edition/${id}`)
        activitySpecialTasks.value = response.data
    }

    const getActivitySpecialTask = async (id) => {
        let response = await axios.get(`/api/backend/activities/tasks/${id}`)
        activitySpecialTask.value = response.data
    }

    const storeActivitySpecialTask = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/activities/tasks', data)
            await showInfo("Zapisano zadanie");
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    }

    const addSpecialTasksEditionTask = async (id, type) => {
        let response = await axios.get(`/api/backend/activities/tasks/add/${id}/${type}`)
        await showInfo('Utworzono nowe zadanie')
    }

    const destroyActivitySpecialTask = async (id) => {
        if (confirm("Czy na pewno usunąć to zadanie?")) {
            await axios.delete(`/api/backend/activities/tasks/${id}`)
            await showInfo('Usunięto zadanie')
        }
    }

    const updatePermissions = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/activities/tasks/${id}/permissions`, activitySpecialTask.value);
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    }

    const updateActivitySpecialTaskDescription = async (id) => {

        errors.value = ''

        try {
            await axios.patch(`/api/backend/activities/task-description/${id}`, activitySpecialTask.value)
            await showInfo('Zapisano zadanie')
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                    await showInfo(errors)
                }
            }
        }
    }

    const updateActivitySpecialTask = async (id) => {

        errors.value = ''

        activitySpecialTask.value.active_from = dateFormat(activitySpecialTask.value.active_from, 'yyyy-MM-dd');
        activitySpecialTask.value.active_to = dateFormat(activitySpecialTask.value.active_to, 'yyyy-MM-dd');

        try {
            await axios.patch(`/api/backend/activities/tasks/${id}`, activitySpecialTask.value)
            await showInfo('Zapisano zadanie')
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                    await showInfo(errors)
                }
            }
        }
    }

    const getRanking = async (id) => {
        let response = await axios.get(`/api/backend/activities/tasks/ranking/${id}`)
        ranking.value = response.data
    }

    const updateRanking = async (id) => {

        errors.value = ''

        ranking.value.active_from = dateFormat(ranking.value.active_from, 'yyyy-MM-dd');
        ranking.value.active_to = dateFormat(ranking.value.active_to, 'yyyy-MM-dd');

        try {
            await axios.patch(`/api/backend/activities/tasks/ranking/${id}`, ranking.value)
            await showInfo("Zaktualizowano dane")
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                    await showInfo(errors)
                }
            }
        }
    }

    return {
        errors,
        activitySpecialTask,
        activitySpecialTasks,
        addSpecialTasksEditionTask,
        getActivitySpecialTask,
        getActivitySpecialTasks,
        storeActivitySpecialTask,
        updateActivitySpecialTask,
        updateActivitySpecialTaskDescription,
        updatePermissions,
        destroyActivitySpecialTask,
        ranking,
        getRanking,
        updateRanking,
        homework,
        descriptive,
    }
}
