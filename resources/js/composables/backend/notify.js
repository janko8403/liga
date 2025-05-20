import { ref } from 'vue'
import axios from 'axios'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useNotifies() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const notify = ref([])
    const notifies = ref([])

    const errors = ref('')

    const getNotifies = async () => {
        let response = await axios.get(`/api/backend/notifies`)
        notifies.value = response.data
    }

    const getNotify = async (id) => {
        let response = await axios.get(`/api/backend/notifies/${id}`)
        notify.value = response.data
    }

    const storeNotify = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/notifies', data)
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                    await showInfo(errors);
                }
            }
        }
    }

    const destroyNotify = async (id) => {
        if (confirm("Czy na pewno usunąć to powiadomienie?")) {
            await axios.delete(`/api/backend/notifies/${id}`)
        }
    }

    const updateNotify = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/notifies/${id}`, notify.value)
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

    return {
        errors,
        notify,
        notifies,
        getNotify,
        getNotifies,
        storeNotify,
        updateNotify,
        destroyNotify
    }
}
