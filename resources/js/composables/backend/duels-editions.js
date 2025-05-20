import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useDuelsEditions() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const duelsEdition = ref([])
    const duelsEditions = ref([])

    const errors = ref('')
    const router = useRouter()

    const getDuelEditions = async () => {
        let response = await axios.get('/api/backend/duels-editions')
        duelsEditions.value = response.data
    }

    const getDuelEdition = async (id) => {
        let response = await axios.get(`/api/backend/duels-editions/${id}`)
        duelsEdition.value = response.data
    }

    const storeDuelEdition = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/duels-editions', data)
            await showInfo("Zapisano nową edycję");
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                await showInfo(errors);
            }
        }
    }

    const destroyDuelEdition = async (id) => {
        if (confirm("Czy na pewno usunąć kategorię pojedynku?")) {
            await axios.delete(`/api/backend/duels-editions/${id}`)
            await showInfo("Usunięto edycję");
        }
    }

    const updateDuelEdition = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/duels-editions/${id}`, duelsEdition.value)
            await showInfo("Zapisano zmiany edycji pojedynków");
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                await showInfo(errors);
            }
        }
    }


    return {
        errors,
        duelsEdition,
        duelsEditions,
        getDuelEdition,
        getDuelEditions,
        storeDuelEdition,
        updateDuelEdition,
        destroyDuelEdition
    }
}
