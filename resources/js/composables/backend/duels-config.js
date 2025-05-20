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

export default function useDuelsConfig() {
    let toast = useToast()
    let showInfo = (info) => {
        if (info) {
            toast.show({ title: info })
        }
        else {
            toast.show({ title: errors })
        }
    }
    const duelConfig = ref([])
    const errors = ref('')

    const getDuelConfig = async (id) => {
        let response = await axios.get(`/api/backend/duelsConfig`)
        duelConfig.value = response.data.data
    }

    const updatePermissions = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/backend/duelsConfig/permissions`, duelsConfig.value);
        } catch (e) {
            if (e.response && 419 === e.response.status) {
                window.location.reload()
            }
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                    await showInfo(errors);
                }
            }
        }
    }

    const updateDuelConfig = async (id) => {
        errors.value = ''
        duelConfig.value.active_from = dateFormat(duelConfig.value.active_from, 'yyyy-MM-dd');
        duelConfig.value.active_to = dateFormat(duelConfig.value.active_to, 'yyyy-MM-dd');

        try {
            await axios.patch(`/api/backend/duelsConfig/${id}`, duelConfig.value)
            await showInfo("Zapisano konfigurację pojedynków");
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
        duelConfig,
        getDuelConfig,
        updateDuelConfig,
        updatePermissions,
    }
}
