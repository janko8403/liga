import { ref } from 'vue'
import axios from 'axios'

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useUsersPermissions() {

    const allPermissions = ref([])
    const errors = ref('')

    const getAllPermissions = async () => {
        let response = await axios.get('/api/backend/users_permissions')
        allPermissions.value = response.data
    }

    return {
        errors,
        allPermissions,
        getAllPermissions,
    }
}
