<template>

</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import Files from "../files/FilesIndex";
import multiselect from "vue-multiselect";
import useAnswers from "../../../composables/backend/answers";
import {onMounted, ref} from "vue";

export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            file_type: 'attachment',
            header_file: '',
        }
    },
    components: {
        Datepicker,
        Files,
        multiselect,
        answers,
    },
    setup(props) {
        const { answer, answers, getAnswer, storeAdminAnswer, getAnswers, destroyAnswer } = useAnswers()
        onMounted(() => getAnswers(props.task_id))
        const cKey = ref(0);

        const reRender = () => {
            cKey.value += 1;
        }
    }
}
</script>
