import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import {useToast} from "bootstrap-vue-3";

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};
function dateFormat(inputDate, format) {
    const date = new Date(inputDate);

    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    format = format.replace("MM", month.toString().padStart(2,"0"));

    if (format.indexOf("yyyy") > -1) {
        format = format.replace("yyyy", year.toString());
    } else if (format.indexOf("yy") > -1) {
        format = format.replace("yy", year.toString().substr(2,2));
    }
    format = format.replace("dd", day.toString().padStart(2,"0"));

    return format;
}

export default function useContests() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }

    const contest = ref([])
    const contests = ref([])

    const errors = ref('')

    const getContests = async () => {
        let response = await axios.get(`/api/backend/contests`)
        contests.value = response.data
    }

    const getContest = async (id) => {
        let response = await axios.get(`/api/backend/contests/${id}`)
        contest.value = response.data
    }

    const storeContest = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/backend/contests', data)
            await showInfo("Zapisano nowy konkurs");
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
                await showInfo(errors.value);
            }
        }
    }

    const destroyContest = async (id) => {
        if (confirm("Czy na pewno usunąć ten konkurs?")) {
            await axios.delete(`/api/backend/contests/${id}`)
            await showInfo("Usunięto konkurs");
        }
    }

    const updateContest = async (id) => {
        errors.value = ''

        contest.value.active_from = dateFormat(contest.value.active_from, 'yyyy-MM-dd');
        contest.value.active_to = dateFormat(contest.value.active_to, 'yyyy-MM-dd');

        try {
            await axios.patch(`/api/backend/contests/${id}`, contest.value)
            await showInfo("Zapisano dane konkursu");

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

    return {
        errors,
        contest,
        contests,
        getContest,
        getContests,
        storeContest,
        updateContest,
        destroyContest
    }
}
