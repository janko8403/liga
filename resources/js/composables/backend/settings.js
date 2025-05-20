import { ref } from 'vue'
import axios from 'axios'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useSettings() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const appSetting = ref([])
    const appSettings = ref([])
    const errors = ref('')

    const getSettings = async (id) => {
        let response = await axios.get(`/api/backend/settings`)
        appSettings.value = response.data
    }

    const getSetting = async (id) => {
        let response = await axios.get(`/api/backend/settings/${id}`)
        appSetting.value = response.data
    }

    const updateSettings = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/settings/${id}`, appSetting.value)
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
        appSetting,
        getSetting,
        updateSettings,
    }
}
