<template>
    <div class="h3 mb-3">
        <router-link :to="{ name: 'activities.editEdition', params: {id : task.edition_id, activity_id : '3' }}">
            <i class="fa-solid fa-chevron-left" style="color:#000"></i>
        </router-link>
        Zadanie Specjalne Quiz
        <span class="text-muted h3 ml-1">| {{ task.name }}</span>
    </div>
    <SpecialTaskQuizQuestions :task_id="task.id"></SpecialTaskQuizQuestions>
</template>

<script>
import {useToast} from 'bootstrap-vue-3';
import {nextTick, onMounted, ref} from 'vue';

import useQuestions from "../../../composables/backend/quiz-questions";
import SpecialTaskQuizQuestions from "./SpecialTaskQuizQuestions";

export default {
    props: {
        task: {
            required: true,
        },
    },
    components : {
        SpecialTaskQuizQuestions
    },
    setup(props) {
        const { errors, question, questions, destroyQuestion, updateQuestion, storeQuestion, getQuestions, getQuestion} = useQuestions()

        let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let toast = useToast()
        let showInfo = () => {
            toast.show({title: errors })
        }
        onMounted(() => getQuestions(props.task.id))

        const addQuestion = async (type) => {
            await storeQuestion(props.task.id,type)
        }

        const saveQuestion = async () => {
            await updateQuestion(props.task.id)
        }

        const deleteQuestion = async (question_id) => {
            await destroyQuestion(question_id)
            await nextTick()
            await getQuestions(props.task.id)
        }

        return {
            errors,
            csrf,
            question,
            questions,
            addQuestion,
            saveQuestion,
            deleteQuestion,
            showInfo,
        }
    },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
