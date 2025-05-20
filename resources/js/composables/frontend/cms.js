import {nextTick, ref} from 'vue'
import axios from 'axios'

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

export default function useCMS() {
    const section = ref([])
    const contest = ref([])
    const contests = ref([])
    const quizQuestions = ref([])
    const sections = ref([])
    const user = ref([])
    const answer = ref([])
    const access = ref([])
    const topResults = ref([])
    const activityInfo = ref([])

    const activityUsers = ref([])
    const activityResults = ref([])
    const specialTasksEditions = ref([])
    const specialTask = ref([])

    const errors = ref('')

    const getSections = async (id) => {
        let response = await axios.get(`/api/frontend/cms/sections/${id}`)
        sections.value = response.data
    }

    const getActivityTopResults = async (activity_id) => {
        let response = await axios.get(`/api/frontend/top/${activity_id}`)
        topResults.value = response.data
    }

    const getActivityInfo = async (activity_id,edition_id=0) => {
        let response = await axios.get(`/api/frontend/activity-info/${activity_id}/${edition_id}`)
        activityInfo.value = response.data
    }

    const getSection = async (id) => {
        let response = await axios.get(`/api/frontend/cms/section/${id}`)
        section.value = response.data.data
    }

    /* bsr */

    const activityData = ref([])
    const duels = ref([])

    const getActivityData = async (id) => {
        let response = await axios.get(`/api/frontend/cms/activity-data/${id}`)
        activityData.value = response.data
    }

    const getActivityUsers = async (id) => {
        let response = await axios.get(`/api/frontend/cms/activity-users/${id}`)
        activityUsers.value = response.data
    }

    const getQuizQuestions = async (id) => {
        let response = await axios.get(`/api/frontend/cms/quiz-questions/${id}`)
        quizQuestions.value = response.data
    }

    const getSpecialTasksEditions = async (id) => {
        let response = await axios.get(`/api/frontend/cms/special-tasks-editions/${id}`)
        specialTasksEditions.value = response.data
    }

    const getContests = async () => {
        let response = await axios.get(`/api/frontend/cms/contests`)
        contests.value = response.data
    }

    const getContest = async (id) => {
        let response = await axios.get(`/api/frontend/cms/contests/${id}`)
        contest.value = response.data
        await nextTick()
        let listItems = document.querySelectorAll('.editor-content ol');
        for(let i = 0; i < listItems.length; i++) {
            listItems[i].className = 'list';
        }
        let listItems2 = document.querySelectorAll('.editor-content ul');
        for(let i = 0; i < listItems2.length; i++) {
            listItems2[i].className = 'list-number';
        }
    }

    const getActivityResults = async (id,limit=0) => {
        let response = await axios.get(`/api/frontend/cms/activity-results/${id}/${limit}`)
        activityResults.value = response.data;
    }

    const getUserData = async () => {
        let response = await axios.get(`/api/me`)
        user.value = response.data
    }

    const getSpecialTask = async (taskslug) => {
        let response = await axios.get(`/api/frontend/cms/special-tasks/${taskslug}`)
        specialTask.value = response.data
    }

    const getUserSpecialTaskAccess = async (taskslug) => {
        let response = await axios.get(`/api/frontend/cms/special-tasks-answers/${taskslug}`)
        access.value = response.data
    }

    const storeUserSpecialTaskAnswer = async (data) => {
        errors.value = ''
        try {
            await axios.post(`/api/frontend/cms/special-tasks-answers/`, data)
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }

    }

    const getDuels = async () => {
        let response = await axios.get(`/api/frontend/duels`)
        duels.value = response.data
    }

    /* bsr end */
    return {
        errors,
        duels,
        getDuels,
        getUserSpecialTaskAccess,
        storeUserSpecialTaskAnswer,
        user,
        answer,
        access,
        contest,
        quizQuestions,
        getQuizQuestions,
        getActivityInfo,
        getActivityTopResults,
        contests,
        getContests,
        getContest,
        specialTask,
        activityInfo,
        topResults,
        getSpecialTask,
        getUserData,
        sections,
        activityUsers,
        activityResults,
        getActivityResults,
        getActivityUsers,
        specialTasksEditions,
        getSpecialTasksEditions,
        getSections,
        getSection,
        activityData,
        getActivityData,
    }
}
