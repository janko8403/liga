import {nextTick, ref} from 'vue'
import axios from 'axios'
import {useToast} from "bootstrap-vue-3";
import { useRouter } from 'vue-router'

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useCMSSection() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const section = ref([])
    const sections = ref([])
    const dictSections = ref([])

    const errors = ref('')
    const router = useRouter()

    const getSections = async (menu_id) => {
        errors.value = ''
        try {
            let response = await axios.get(`/api/backend/cms/sections/menu/${menu_id}`)
            sections.value = response.data.data
        } catch (e) {
            if (e.response.status === 404) {
                await router.push({name: 'notfound'});
            }
        }
    }

    const getSectionsDefinitions = async() => {
        let response = await axios.get('/api/backend/cms/sections/dictionary')
        dictSections.value = response.data.data
    }

    const getSection = async (id) => {
        let response = await axios.get(`/api/backend/cms/sections/${id}`)
        section.value = response.data
    }

    const storeSection = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/cms/sections', data)
            await showInfo('Utworzono nową sekcję')
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                await showInfo(errors.value)
            }
        }
    }

    const destroySection = async (id) => {
        await axios.delete(`/api/backend/cms/sections/${id}`)
        await nextTick()
        await showInfo('Usunięto sekcję')
    }

    const updateSection = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/cms/sections/${id}`, content.value)
            await showInfo('Zapisano sekcję')
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
        section,
        sections,
        dictSections,
        getSections,
        getSection,
        getSectionsDefinitions,
        storeSection,
        updateSection,
        destroySection
    }
}
