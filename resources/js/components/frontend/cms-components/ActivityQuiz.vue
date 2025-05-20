<template>
    <div class="container">

        <ul class="breadcrumb ms-1">
            <li><a href="/">Strona główna</a></li>
            <li><a href="/zadania-specjalne">Zadania Specjalne</a></li>
            <li>{{ specialTask.name }}</li>
        </ul>

        <div class="row mt-4">
            <div class="col">
                <div class="activity-box">
                    <div class="activity-box_content">
                        <div class="row pt-5 pb-5">
                            <div class="col-12 col-md-12 d-block d-md-flex justify-content-between">
                                <div class="title-header">{{ specialTask.name }}</div>
                                <div class="title-header mt-4 mt-md-0"><quiz-timer v-if="specialTask.quiz_time>0" :timer_count="specialTask.quiz_time"></quiz-timer></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card-results">
                    <h2 class="pb-4">Pytanie</h2>

                    <p v-html="quizQuestions.title"></p>

                    <template v-if="quizQuestions.type == 'm'">
                    <div class="row pt-5">
                        <div class="col-md-12">
                            <template v-for="opt in quizQuestions.options">
                                <label class="checkboxcontainer mt-3"> {{ opt.name }}
                                    <input type="checkbox">
                                    <span class="checkmark checkmark_active"></span>
                                </label>
                            </template>
                            <label class="checkboxcontainer mt-3"> Lorem ipsum dolor sit amet, consectetur
                                <input type="checkbox">
                                <span class="checkmark checkmark_active"></span>
                            </label>
                            <label class="checkboxcontainer mt-3"> Lorem ipsum dolor sit amet, consectetur
                                <input type="checkbox">
                                <span class="checkmark checkmark_active"></span>
                            </label>
                        </div>
                    </div>
                    </template>
                    <template v-if="quizQuestions.type == 's'">
                    <div class="row pt-5">
                        <div class="col-md-12">
                            <template v-for="opt in quizQuestions.options">
                                <label class="radiocontainer">{{ opt.name }}
                                    <input type="radio" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                    </template>

                    <div class="row pt-4">
                        <div class="col-md-12 d-block d-md-flex justify-content-end">
                            <!--<div class="title-with-icon_red icon-font icon-color_r icon_v icon-font_sm mt-4 mt-md-4 mb-5 mb-md-0 me-5">Nie udzieliłeś odpowiedzi!</div>-->
                            <button class="btn-pzu btn-pzu_blue">kolejne pytanie</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import useCMS from "../../../composables/frontend/cms";
import Accordion from '../subcomponents/Accordion'
import {onMounted} from "vue";
import QuizTimer from "../QuizTimer";


export default {
    props: {
        task: {
            required: true
        }
    },
    components: {
        QuizTimer,
        Accordion
    },
    setup(props) {
        const { activityData, getActivityData, getSpecialTask, getQuizQuestions, quizQuestions, specialTask } = useCMS()
        onMounted(() => getActivityData(3))
        onMounted(() => getSpecialTask(props.task.slug))
        onMounted(() => getQuizQuestions(props.task.id))

        function currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth() + 1}.${current.getFullYear()}`;
        }
        return {
            activityData,
            specialTask,
            quizQuestions,
            currentDate,
        }
    },
}
</script>
