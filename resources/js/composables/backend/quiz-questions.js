import {nextTick, ref} from 'vue'
import axios from 'axios'
import {useToast} from 'bootstrap-vue-3';

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useQuestions() {

    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const question = ref([])
    const questionOptions = ref([])
    const questions = ref([])

    const errors = ref('')

    const getQuestions = async (id) => {
        let response = await axios.get(`/api/backend/questions/task/${id}`)
        questions.value = response.data
    }

    const getQuestion = async (id) => {
        let response = await axios.get(`/api/backend/questions/${id}`)
        question.value = response.data
    }

    const storeQuestion = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/questions', data)
            await nextTick()
            await showInfo('Zapisano nowe pytanie')
        } catch (e) {
            if (e.response.status > 400) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                showInfo()
            }
        }
    }

    const destroyQuestion = async (id) => {
        if (confirm("Czy na pewno usunąć to pytanie?")) {
            await axios.delete(`/api/backend/questions/${id}`)
            await nextTick()
            await showInfo('Usunięto pytanie')
        }
    }

    const updateQuestion = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/questions/${id}`, question.value)
        } catch (e) {
            if (e.response.status > 300) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                    await showInfo(errors);
                }
                showInfo(errors.value)
            }
        }
    }

    const getQuestionOptions = async (id) => {
        let response = await axios.get(`/api/backend/questions/question-options/${id}`)
        questionOptions.value = response.data
    }

    const updateQuestionOptions = async (id) => {
        let response = await axios.patch(`/api/backend/questions/question-options/${id}`, questionOptions)
        questionOptions.value = response.data
        showInfo('Zapisano opcję pytania')
    }

    const storeQuestionOption = async (id) => {
        let response = await axios.get(`/api/backend/questions/question-options/new/${id}`)
        showInfo('Dodano nową odpowiedź')
    }

    const destroyQuestionOption = async (id) => {
        if (confirm("Czy na pewno usunąć tą odpowiedź?")) {
            await axios.delete(`/api/backend/questions/question-options/${id}`)
            await nextTick()
            await showInfo('Usunięto odpowiedź')
        }
    }

    return {
        errors,
        question,
        questions,
        questionOptions,
        getQuestionOptions,
        updateQuestionOptions,
        storeQuestionOption,
        destroyQuestionOption,
        getQuestion,
        getQuestions,
        storeQuestion,
        updateQuestion,
        destroyQuestion
    }
}
