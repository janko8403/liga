import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useAdmins() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const admin = ref([])
    const admins = ref([])
    const adminPermissions = ref([])

    const errors = ref('')
    const router = useRouter()

    const getAdmins = async () => {
        let response = await axios.get('/api/backend/admins')
        admins.value = response.data.data
    }

    const getAdmin = async (id) => {
        let response = await axios.get(`/api/backend/admins/${id}`)
        admin.value = response.data.data
    }

    const storeAdmin = async (admin) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/admins', admin)
            await showInfo("Zapisano nowego administratora");
            await router.push({ name: 'admins.index' })
        } catch (e) {
            console.log(e)
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                showInfo(errors.value);
            }
        }
    }

    const destroyAdmin = async (id) => {
        if (confirm("Czy na pewno usunąć tego administratora?")) {
            await axios.delete(`/api/backend/admins/${id}`)
            await showInfo('Administrator został usunięty')
        }
    }

    const updateAdmin = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/admins/${id}`, admin.value)
            await showInfo('Zapisano zmiany')
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

    const getAdminsPermissions = async () => {
        let response = await axios.get('/api/backend/admins_permissions')
        adminPermissions.value = response.data
    }

    return {
        errors,
        admin,
        admins,
        getAdmin,
        getAdmins,
        getAdminsPermissions,
        adminPermissions,
        storeAdmin,
        updateAdmin,
        destroyAdmin
    }
}
