import {nextTick, ref} from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import {useToast} from "bootstrap-vue-3";
import {next} from "lodash/seq";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useDuels() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const freeMSK = ref([])
    const freeDSK = ref([])
    const firstNepu = ref([])
    const secondNepu = ref([])
    const duel = ref([])
    const duels = ref([])

    const errors = ref('')
    const router = useRouter()

    const getDuels = async (id) => {
        let response = await axios.get(`/api/backend/duels/edition/${id}`)
        duels.value = response.data
    }

    const getDuel = async (id) => {
        let response = await axios.get(`/api/backend/duels/${id}`)
        duel.value = response.data
    }

    const getDuelFreeMSKUsers = async (edition_id,first_nepu="0",second_nepu="0") => {
        let response = await axios.get(`/api/backend/duels/edition/${edition_id}/msk-teams/${first_nepu}/${second_nepu}`)
        freeMSK.value = response.data
        firstNepu.value = freeMSK.value.find(msk => msk.nepu_msk == first_nepu)
        secondNepu.value = freeMSK.value.find(msk => msk.nepu_msk == second_nepu)
    }

    const getDuelFreeDSKUsers = async (edition_id) => {
        let response = await axios.get(`/api/backend/duels/edition/${edition_id}/dsk-teams`)
        freeDSK.value = response.data
    }

    const storeDuel = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/duels', data)
            await nextTick()
            await showInfo("Zapisano nowy pojedynek");
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    }

    const destroyDuel = async (id) => {
        if (confirm("Czy na pewno usunąć ten pojedynek?")) {
            await axios.delete(`/api/backend/duels/${id}`)
            await nextTick()
            await showInfo("Usunięto pojedynek");
        }
    }

    const updateDuel = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/duels/${id}`, duel.value)
            await nextTick()
            await showInfo("Zapisano zmiany w pojedynku");
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
            await showInfo(errors.value)
        }
    }

    return {
        errors,
        duel,
        duels,
        freeDSK,
        freeMSK,
        firstNepu,
        secondNepu,
        getDuelFreeMSKUsers,
        getDuelFreeDSKUsers,
        getDuel,
        getDuels,
        storeDuel,
        updateDuel,
        destroyDuel
    }
}
