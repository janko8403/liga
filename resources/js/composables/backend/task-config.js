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

export default function useTaskConfig() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const taskConfig = ref([])
    const errors = ref('')

    const getTaskConfig = async (id) => {
        let response = await axios.get(`/api/backend/taskConfig`)
        taskConfig.value = response.data.data
    }

    const updatePermissions = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/taskConfig/permissions`, taskConfig.value);
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                await showInfo(errors);
            }
        }
    }

    const updateTaskConfig = async (id) => {
        errors.value = ''
        taskConfig.value.active_from = dateFormat(activity.value.active_from, 'yyyy-MM-dd');
        taskConfig.value.active_to = dateFormat(activity.value.active_to, 'yyyy-MM-dd');

        try {
            await axios.patch(`/api/backend/taskConfig/${id}`, activity.value)
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                    await showInfo(errors);
                }
            }
        }
    }

    return {
        errors,
        taskConfig,
        getTaskConfig,
        updateTaskConfig,
        updatePermissions,
    }
}
