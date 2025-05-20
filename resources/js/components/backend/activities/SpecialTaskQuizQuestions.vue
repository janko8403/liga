<template>
    <div class="row justify-content-center mt-3">
        <div class="col-12">
        <nav class="navbar navbar-light bg-light justify-content-between p-3">
            <a class="navbar-brand">Nowe pytanie</a>
            <div class="justify-content-end">
                <button class="btn btn-secondary my-2 me-4" @click='addQuestion("s")' type="submit">Nowe pytanie jednokrotnego wyboru</button>
                <button class="btn btn-secondary my-2 ml-2" @click='addQuestion("m")' type="submit">Nowe pytanie wielokrotnego wyboru</button>
            </div>
        </nav>
        <div class="">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>Pytanie</th>
                    <th>Rodzaj</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in questions" :key="item.id">
                    <td scope="row">
                    </td>
                    <td>
                        {{ item.title }}
                    </td>
                    <td>
                        <span v-if='item.type === "m"'>Wielokrotny wybór</span>
                        <span v-if='item.type === "s"'>Jednokrotny wybór</span>
                    </td>
                    <td>
                        <span class="mr-2">
                            <i class="fa fa-solid fa-edit pointer" type="button" data-bs-toggle="modal" data-bs-target="#questionModal" title="Pokaż szczegóły pytania" @click='editQuizQuestion(item.id)'></i>
                        </span>
                        <span>
                            <i class="fa fa-solid fa-trash pointer" title="Usuń pytanie" @click='deleteQuizQuestion(item.id)'></i>
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <div class="modal modal-lg fade" id="questionModal" tabindex="-1" aria-labelledby="quaestionModalLabel" aria-hidden="true">
        <div class="modal-dialog" bs-modal-width="80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionModalLabel">Pytanie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                </div>
                <div class="modal-body mb-3">
                    <SpecialTaskQuizQuestion v-if="question.id > 0" :question_id="question.id" :key="cKey"></SpecialTaskQuizQuestion>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {nextTick, onMounted, ref} from 'vue';
import useQuizQuestions from "../../../composables/backend/quiz-questions";
import ActivityDataImport from "../activities/ActivityDataImport";
import SpecialTaskQuizQuestion from "./SpecialTaskQuizQuestion";

export default {
    components: {SpecialTaskQuizQuestion, ActivityDataImport },
    props: {
        task_id: {
            required: true,
        },
    },
    setup(props) {
        const { question, questions, getQuestion, storeQuestion, getQuestions, destroyQuestion } = useQuizQuestions()
        onMounted(() => getQuestions(props.task_id))
        const cKey = ref(0);
        let rowIndex = ref(1);
        const reRender = () => {
            cKey.value += 1;
        }

        const deleteQuizQuestion = async (id) => {
            await destroyQuestion(id);
            await nextTick();
            await getQuestions(props.task_id)
        }

        const addQuestion = async (type) => {
            await storeQuestion({'special_task_id': props.task_id, 'type': type});
            await nextTick();
            await getQuestions(props.task_id)
        }

        const editQuizQuestion = async (id) => {
            await getQuestion(id)
            await nextTick();
            await reRender();
        }

        return {
            cKey,
            rowIndex,
            question,
            questions,
            editQuizQuestion,
            deleteQuizQuestion,
            addQuestion,
        }
    },
}
</script>
