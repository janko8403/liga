import { ref } from 'vue'
import axios from 'axios'

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useFiles() {

    const file = ref([])
    const files = ref([])

    const errors = ref('')

    const getFiles = async (activity_id,type) => {
        let response = await axios.get(`/api/frontend/files/${activity_id}/${type}`)
        files.value = response.data
    }

    const getFile = async (id) => {
        let response = await axios.get(`/api/frontend/files/${id}`)
        file.value = response.data
    }

    return {
        errors,
        file,
        files,
        getFile,
        getFiles,
    }
}
