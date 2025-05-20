<template>
    <div class="row justify-content-center mt-5">
        <div class="col-12">
            <div class="col-12">
                <form class="row g-3" v-on:submit.prevent="saveQuestion" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="_token" v-bind:value="csrf">
                        <div class="col-12 mt-3">
                            <label for="name" class="form-label">Treść pytania</label>
                            <input type="text" v-model="question.title" class="form-control" id="title">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="name" class="form-label col-12">Ilość punktów za poprawną odpowiedź</label>
                            <input type="number" min="0" max="100" v-model="question.points" class="form-control" id="name" style="width:150px">
                        </div>
                    </div>
                <div class="row">
                        <div class="col-12 mt-3">
                            <nav class="navbar navbar-light bg-light justify-content-between p-3">
                                <a class="navbar-brand"></a>
                                <div class="justify-content-end">
                                    <div class="btn btn-secondary my-2 ml-2" @click='addQuestionOption' type="submit">Dodaj odpowiedź</div>
                                </div>
                            </nav>
                            <template v-if='question.type === "s"'>
                                <div class="form-check mt-2">
                                    <table>
                                        <tr>
                                            <th class="p-2" >Poprawna odpowiedź</th>
                                            <th class="p-2">Treść</th>
                                        </tr>
                                        <tr v-for="question_option in questionOptions">
                                            <td align="right">
                                                <input class="form-check-input" :checked="question_option.is_correct == 1 || question_option.is_correct == 'on'" name="is_correct" type="radio" v-model="question_option.is_correct" id="option-{{question_option.id}}" style="margin-left: 4em !important">
                                            </td>
                                            <td style="width:70%">
                                                <label class="form-check-label" for="option-{{question_option.id}}" style="width:100%">
                                                    <input type="text" class="form-control" v-model="question_option.name" style="width:100%;">
                                                </label>
                                            </td>
                                            <td style="width:130px;">
                                                <span>
                                                        <i class="fa fa-trash pointer" title="Usuń pytanie" @click="deleteQuestionOption(question_option.id)"></i>
                                                    </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </template>
                            <template v-if='question.type === "m"'>
                                    <div class="form-check mt-2">
                                    <table>
                                        <tr>
                                            <th class="p-2" >Poprawna odpowiedź</th>
                                            <th class="p-2">Treść</th>
                                        </tr>
                                        <tr v-for="question_option in questionOptions">
                                            <td>
                                                <input class="form-check-input" v-bind:checked="question_option.is_correct === 1" v-model="question_option.is_correct" type="checkbox" style="margin-left: 4em !important">
                                            </td>
                                            <td style="width:70%">
                                                <label class="form-check-label" style="width:100%">
                                                <input type="text" class="form-control" v-model="question_option.name" style="width:100%;">
                                                </label>
                                            </td>
                                            <td style="width:140px;">
                                                <span>
                                                    <i class="fa fa-trash pointer" title="Usuń pytanie" @click="deleteQuestionOption(question_option.id)"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                <div class="form-check">
                                </div>
                            </template>
                        </div>
                        <div class="col-2 mt-3">
                            <button type="submit" className="btn btn-primary">
                                Zapisz
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {ref, nextTick, onMounted} from "vue";
import Files from '../files/FilesIndex'
import multiselect from 'vue-multiselect'
import Datepicker from '@vuepic/vue-datepicker'
import { QuillEditor as Editor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import useQuestions from "../../../composables/backend/quiz-questions";

export default {
    props: {
        question_id: {
            required: true,
        },
    },
    components: {
        Files,
        multiselect,
        Datepicker,
        Editor,
    },
    setup(props) {
        const { question, questionOptions, storeQuestionOption, updateQuestionOptions, destroyQuestionOption, getQuestionOptions, updateQuestion, getQuestion } = useQuestions()
        onMounted(() => getQuestion(props.question_id))
        onMounted(() => getQuestionOptions(props.question_id))
        const cKey = ref(0);

        const reRender = () => {
            cKey.value += 1;
        }

        const saveQuestion = async () => {
            await updateQuestion(props.question_id)
            await nextTick();
            await updateQuestionOptions(props.question_id);
            await nextTick();
            await getQuestion(props.question_id)
            await nextTick();
            await getQuestionOptions(props.question_id)
        }

        const addQuestionOption = async () => {
            await updateQuestionOptions(props.question_id);
            await nextTick();
            await storeQuestionOption(props.question_id)
            await nextTick();
            await getQuestionOptions(props.question_id)
        }

        const deleteQuestionOption = async (id) => {
            await destroyQuestionOption(id);
            await nextTick();
            await getQuestionOptions(props.question_id)
        }

        const saveQuestionOption = async (id) => {
            await updateQuestionOptions(id);
        }

        return {
            question,
            cKey,
            saveQuestion,
            addQuestionOption,
            saveQuestionOption,
            deleteQuestionOption,
            questionOptions,
            reRender,
            file_type: 'contest',
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            header_file: '',
        }
    },
}
</script>
