import { ref } from 'vue'
import axios from 'axios'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useHomeworks() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const homework = ref([])
    const errors = ref('')

    const getHomework = async (id) => {
        let response = await axios.get(`/api/backend/homeworks/${id}`)
        homework.value = response.data
    }

    const updateHomework = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/homeworks/${id}`, homework.value)
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
        homework,
        getHomework,
        updateHomework,
    }
}
