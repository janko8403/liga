import { ref } from 'vue'
import axios from 'axios'
import { useToast } from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useCMSSectionData() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const sectionData = ref([])
    const sectionDefs = ref([])
    const activityData = ref([])

    const errors = ref('')

    const getSectionData = async (section_id,component_id) => {
        let response = await axios.get(`/api/backend/cms/sections/data/${section_id}/${component_id}`)
        sectionData.value = response.data.data
        sectionData.toString();
    }

    const getSectionDefinitions = async(component_id) => {
        let response = await axios.get(`/api/backend/cms/sections/dictionary/${component_id}`)
        sectionDefs.value = response.data.data
    }

    const destroySection = async (id) => {
        if (confirm("Czy na pewno usunąć ten element?")) {
            await axios.delete(`/api/backend/cms/sections/${id}`)
            await showInfo('Usunięto sekcję')
        }
    }

    const updateSectionData = async (id) => {
        errors.value = ''
        try {
            await axios.post(`/api/backend/cms/sections/data/${id}`, sectionData.value)
            await showInfo('Zapisano zmiany sekcji')
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

    const moveSection = async (id,direction) => {
        try {
            await axios.get(`/api/backend/cms/sections/move/${id}/${direction}`)
            await showInfo('Zapisano przesunięcie')
        } catch (e) {

        }
    }

    return {
        errors,
        sectionData,
        activityData,
        moveSection,
        getSectionData,
        getSectionDefinitions,
        updateSectionData,
        destroySection,
    }
}
