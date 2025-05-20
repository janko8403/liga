import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useUsers() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const user = ref([])
    const users = ref([])
    const permissions = ref([])

    const errors = ref('')
    const router = useRouter()

    const getUsers = async () => {
        let response = await axios.get('/api/backend/users')
        users.value = response.data
    }

    const getUsersPermissions = async () => {
        let response = await axios.get('/api/backend/users_permissions')
        permissions.value = response.data.data
    }

    const getUser = async (id) => {
        let response = await axios.get(`/api/backend/users/${id}`)
        user.value = response.data
    }

    const sendUserVerificationEmail = async (id) => {
        errors.value = ''
        try {
            let response = await axios.get(`/api/confirm/sendmail/${id}`)
            console.log(response);
            if (response.status === 422) {
                for (const key in response.data.errors) {
                    errors.value += response.data.errors[key][0] + ' ';
                    await showInfo(errors);
                }
            } else {
                await showInfo('Wysłano wiadomość');
            }
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors + ' ';
            }
            await showInfo(errors.value);
        }
    }

    const storeUser = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/users', data)
            await router.push({ name: 'users.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                await showInfo(errors);
            }
        }
    }

    const destroyUser = async (id) => {
        if (confirm("Czy na pewno usunąć tego użytkownika?")) {
            await axios.delete(`/api/backend/users/${id}`)
        }
    }

    const updateUser = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/users/${id}`, user.value)
            await router.push({ name: 'users.index' })
            await showInfo('Zapisano zmiany')
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                showInfo(errors.value)
            }
        }
    }

    const saveUserPhoto = async (id,v,comment) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/users/${id}/${v}`, user.value)
            await showInfo('Zapisano zmiany')
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                showInfo(errors.value)
            }
        }
    }

    return {
        errors,
        user,
        users,
        permissions,
        saveUserPhoto,
        sendUserVerificationEmail,
        getUser,
        getUsers,
        storeUser,
        updateUser,
        getUsersPermissions,
        destroyUser
    }
}
