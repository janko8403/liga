import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useCMSMenu() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const content = ref([])
    const contents = ref([])
    const menus = ref([])
    const mainMenus = ref([])

    const messages = ref('')
    const errors = ref('')
    //const router = useRouter()

    const getContents = async () => {
        let response = await axios.get('/api/backend/cms')
        contents.value = response.data.data
    }

    const getContent = async (id) => {
        let response = await axios.get(`/api/backend/cms/${id}`)
        content.value = response.data.data
    }

    const getMenus = async (id) => {
        await axios.get(`/api/backend/cms/menu/${id}`).then(response => {
            let menu = response.data[0];
            menus.value = JSON.parse(menu.data);
        })
    }

    const getMainMenus = async () => {
        let response = await axios.get(`/api/backend/cms/menus`)
        mainMenus.value = response.data;
    }

    const storeMenu = async (data,id) => {
        errors.value = ''
        try {
            const final = await axios.post('/api/backend/cms/menus', data).then( response => {
                let newPageId = response.data
                getMenus(id)
                showInfo('Zapisano nową stronę');

                if (newPageId>0) {
                    return newPageId
                }
            })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    }

    const destroyContent = async (id) => {
        await axios.delete(`/api/backend/cms/${id}`)
        showInfo('Usunięto stronę');

    }

    const updateContent = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/cms/${id}`, content.value)
            messages.value = 'Zapisano dane'
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    }

    return {
        errors,
        messages,
        content,
        contents,
        menus,
        mainMenus,
        getContent,
        getContents,
        getMenus,
        getMainMenus,
        storeMenu,
        updateContent,
        destroyContent
    }
}
