import { ref } from 'vue'
import axios from 'axios'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useAnswers() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }

    const answer = ref([])
    const answers = ref([])

    const errors = ref('')

    const getAnswers = async (id) => {
        let response = await axios.get(`/api/backend/answers`)
        answers.value = response.data
    }

    const getAnswer = async (id) => {
        let response = await axios.get(`/api/backend/answers/${id}`)
        answer.value = response.data
    }

    const storeAnswer = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/answers', data)
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    }

    const destroyAnswer = async (id) => {
        if (confirm("Czy na pewno usunąć tą odpowiedź?")) {
            await axios.delete(`/api/backend/answers/${id}`)
        }
    }

    const updateAnswer = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/answers/${id}`, duel.value)
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
        answer,
        answers,
        getAnswer,
        getAnswers,
        storeAnswer,
        updateAnswer,
        destroyAnswer
    }
}
