<template>
    <ul class="breadcrumb ms-1">
        <li><a href="/">Strona główna</a></li>
        <li><a href="/zadania-specjalne">Zadania Specjalne</a></li>
        <li>{{ specialTask.name }}</li>
    </ul>
    <div class="row">
        <div class="col">
            <div class="activity-box">
                <div class="activity-box_content">
                    <div class="row pt-5 pb-5">
                        <div class="col-12 col-md-12 col-lg-10 d-block d-md-flex justify-content-between">
                            <div class="title-header">{{ specialTask.name }}</div>
                            <div class="title-with-icon icon-font icon-color_b icon_o icon-font_sm mt-5 mt-md-3">
                                Zadanie Domowe
                            </div>
                            <!--<div class="title-with-icon icon-font icon-color_b icon_d icon-font_sm mt-5 mt-md-3">
                                <span>0 osób</span> bierze udział
                            </div>-->
                            <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-3">
                                <span v-if="task.time_left>0">Do końca {{ specialTask.time_left }} dni</span>
                                <span v-else-if="task.time_left<0">Zakończone</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card-results">

                <div class="row">
                    <div class="col-md-12">
                        <h2>Zasady i punktacja</h2>
                        <p class="pt-5" v-html="specialTask.description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card-results">

                <div class="row">
                    <div class="col-md-12">
                        <h2>Opis zadania</h2>
                        <p class="pt-5" v-html="specialTask.task_description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-if="access === 2">
        <div class="col">
            <div class="card-results">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Zadanie Opisowe</h2>
                        <p class="pt-5">Zrealizuj Zadanie zgodnie z opisem powyżej – Zasady i punktacja. Po pozytywnej weryfikacji wykonania zadania zostaną Ci przyznane punkty grywalizacyjne.</p>
                        <form class="row pt-3 g-3" v-on:submit.prevent="saveAnswer" enctype="multipart/form-data">
                            <input type="hidden" name="_token" v-bind:value="csrf">
                            <textarea name="answer_content" id="answer_content" class="mb-0"></textarea>
                            <!--<p>Ilość pozostałych znaków: 250</p>-->
                            <div class="row">
                                <div class="col d-block d-md-flex justify-content-end">
                                    <button class="btn-pzu btn-pzu_blue mt-4">Wyślij</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-if="access === 1">
        <div class="col">
            <div class="card-results">
                <div class="row">
                    <div class="col-md-12 col-lg-6 offset-lg-3">
                        <div class="icon-font icon-font_no_content icon-color_g text-center pt-5 pb-5">e</div>
                        <h2 class="text-center">Dziękujemy za udział!</h2>
                        <p class="text-center pt-4">Punkty zostaną przyznane po weryfikacji pracy.</p>
                        <p class="text-center mt-5 pt-5 mb-5"><a class="btn-pzu btn-pzu_blue" href="/zadania-specjalne">Wróć
                            do zadań specjalnych</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useCMS from "../../../composables/frontend/cms";
import Accordion from '../subcomponents/Accordion'
import {nextTick, onMounted} from "vue";
import QuizTimer from "../QuizTimer";
import {next} from "lodash/seq";


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
        const { errors, activityData, answer, getActivityData, getSpecialTask, storeUserSpecialTaskAnswer,  specialTask, access, getUserSpecialTaskAccess } = useCMS()
        onMounted(() => getActivityData(3))
        onMounted(() => getSpecialTask(props.task.slug))
        onMounted(() => getUserSpecialTaskAccess(props.task.slug))

        function currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth() + 1}.${current.getFullYear()}`;
        }

        const saveAnswer = async () => {
            let answerContent = document.getElementById('answer_content').value;
            const data = { task_id: props.task.id, answer: answerContent }
            await storeUserSpecialTaskAnswer(data);
            await nextTick();
            await getUserSpecialTaskAccess(props.task.slug);
        }
        return {
            activityData,
            saveAnswer,
            access,
            answer,
            specialTask,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            currentDate,
        }
    },
}
</script>
