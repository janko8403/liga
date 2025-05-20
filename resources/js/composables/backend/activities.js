import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
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

export default function useActivities() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }

    const activity = ref([])
    const activities = ref([])

    const showDataTable = ref(false)
    const tableData = ref([])
    const tableHeaders = ref([])

    const errors = ref('')
    const router = useRouter()

    const getActivities = async () => {
        let response = await axios.get('/api/backend/activities')
        activities.value = response.data.data
    }

    const getActivity = async (id) => {
        let response = await axios.get(`/api/backend/activities/${id}`)
        activity.value = response.data.data
    }

    const storeActivity = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/activities', data)
            await showInfo('Zapisano nową aktywność')
            await router.push({ name: 'activities.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    }

    const destroyActivity = async (id) => {
        if (confirm("Czy na pewno usunąć tą aktywność?")) {
            await axios.delete(`/api/backend/activity/${id}`)
        }
    }

    const updatePermissions = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/activities/${id}/permissions`, activity.value);
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

    const updateActivity = async (id) => {

        errors.value = ''

        activity.value.active_from = dateFormat(activity.value.active_from, 'yyyy-MM-dd');
        activity.value.active_to = dateFormat(activity.value.active_to, 'yyyy-MM-dd');

        try {
            await axios.patch(`/api/backend/activities/${id}`, activity.value)
            await showInfo('Zapisano zmiany w aktywności')
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                await showInfo(errors.value)
            }
        }
    }

    const getLeagueActivityData = async (activity_type,type) => {
        showDataTable.value = false;
        let data_response = await axios.get(`/api/backend/activities/${type}/data/${activity_type}`)
        let headers_response = await axios.get(`/api/backend/activities/${type}/headers/${activity_type}`)
        tableData.value = data_response.data;
        tableHeaders.value = headers_response.data;
        showDataTable.value = true;
    }

    return {
        errors,
        tableData,
        tableHeaders,
        showDataTable,
        activity,
        activities,
        getLeagueActivityData,
        getActivity,
        getActivities,
        storeActivity,
        updateActivity,
        updatePermissions,
        destroyActivity
    }
}
