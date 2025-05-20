import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import { useToast } from "bootstrap-vue-3";

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

export default function useActivityEditions() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const activityEdition = ref([])
    const activityEditions = ref([])

    const errors = ref('')
    const router = useRouter()

    const getActivityEditions = async (id) => {
        let response = await axios.get(`/api/backend/activities/${id}/editions`)
        activityEditions.value = response.data.data
    }

    const getActivityEdition = async (id) => {
        let response = await axios.get(`/api/backend/activities/editions/${id}`)
        activityEdition.value = response.data[0]
    }

    const storeActivityEdition = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/activities/editions/new', data)
            await showInfo('Utworzono nową edycję')
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                await showInfo(errors.value)
            }
        }
    }

    const destroyActivityEdition = async (id) => {
        if (confirm("Czy na pewno usunąć tą edycję?")) {
            await axios.delete(`/api/backend/activity/editions/${id}`)
            await showInfo('Usunięto edycję')
        }
    }

    const updatePermissions = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/activities/editions/${id}/permissions`, activityEdition.value);
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

    const updateActivityEdition = async (id) => {

        errors.value = ''

        activityEdition.value.active_from = dateFormat(activityEdition.value.active_from, 'yyyy-MM-dd');
        activityEdition.value.active_to = dateFormat(activityEdition.value.active_to, 'yyyy-MM-dd');

        try {
            await axios.patch(`/api/backend/activities/editions/${id}`, activityEdition.value)
            await showInfo('Zapisano dane edycji')
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

    return {
        errors,
        activityEdition,
        activityEditions,
        getActivityEdition,
        getActivityEditions,
        storeActivityEdition,
        updateActivityEdition,
        updatePermissions,
        destroyActivityEdition
    }
}
