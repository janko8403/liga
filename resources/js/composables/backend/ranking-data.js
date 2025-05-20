import { ref } from 'vue'
import axios from 'axios'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useRecords() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const record = ref([])
    const records = ref([])

    const errors = ref('')

    const getRecords = async (id,record_type) => {
        let response = await axios.get('/api/backend/records',{ params: { activity_id: activity_id, record_type: record_type } })
        records.value = response.data
    }

    const getRecord = async (id) => {
        let response = await axios.get(`/api/backend/records/${id}`)
        record.value = response.data.data
    }

    return {
        errors,
        record,
        records,
        getRecord,
        getRecords,
    }
}
