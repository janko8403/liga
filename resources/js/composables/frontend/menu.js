import { ref } from 'vue'
import axios from 'axios'

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useCMSMenus() {
    const menus = ref([])
    const user = ref([])
    const errors = ref('')

    const getMenus = async (id) => {
        let response = await axios.get(`/api/frontend/menus/${id}`)
        menus.value = response.data
    }

    const getUserData = async () => {
        let response = await axios.get(`/api/me`)
        user.value = response.data
    }


    return {
        errors,
        user,
        getUserData,
        menus,
        getMenus,
    }
}
