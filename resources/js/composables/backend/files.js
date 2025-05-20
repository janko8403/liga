import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useFiles() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const file = ref([])
    const files = ref([])

    const errors = ref('')

    const getFiles = async (activity_id,type) => {
        let response = await axios.get(`/api/backend/files/${activity_id}/${type}`)
        files.value = response.data
    }

    const getFile = async (id) => {
        let response = await axios.get(`/api/backend/files/${id}`)
        file.value = response.data
    }

    const storeFile = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/files', data)
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                await showInfo(errors.value);
            }
        }
    }

    const deleteFile = async (id) => {
        if (confirm("Czy na pewno usunąć ten plik?")) {
            await axios.delete(`/api/backend/files/${id}`)
        }
    }

    return {
        errors,
        file,
        files,
        getFile,
        getFiles,
        storeFile,
        deleteFile
    }
}
