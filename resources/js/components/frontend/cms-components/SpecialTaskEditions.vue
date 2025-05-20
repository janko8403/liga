<template>
    <div class="row">
        <div class="col">
            <div class="card-results">
                <h2 class="pb-4">Edycje</h2>
                <div class="tabs">
                    <div v-if="specialTasksEditions" v-for="edition in specialTasksEditions" :key="edition.id">
                        <input type="radio" name="tabs" :id="'tab'+edition.id">
                        <label :for="'tab'+edition.id">{{ edition.name }}</label>
                        <div class="tab">
                            <div class="row pt-4">
                                <template v-if="edition.tasks" v-for="task in edition.tasks">
                                <div class="col-md-12 col-lg-6">
                                    <div class="swiper-results_box">
                                        <div class="row">
                                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                                <h5 class="pt-2">{{task.name}}</h5>
                                                <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-3">
                                                    <span v-if="task.time_left>0">Do końca {{ task.time_left }} dni</span>
                                                    <span v-else-if="task.time_left<0">Zakończone</span>
                                                </div>
                                                <!--<div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-3" v-if="task.type != 'Ranking'">Zrealizowane</div>-->
                                            </div>
                                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                                <div v-if="task.type === 'Quiz'" class="title-with-icon icon-font icon-color_b icon_p icon-font_sm mt-3">{{ task.type }}</div>
                                                <div v-if="task.type === 'Zadanie Opisowe'" class="title-with-icon icon-font icon-color_b icon_o icon-font_sm mt-3">{{ task.type }}</div>
                                                <div v-if="task.type === 'Zadanie Domowe'" class="title-with-icon icon-font icon-color_b icon_o icon-font_sm mt-3">{{ task.type }}</div>
                                                <div v-if="task.type === 'Ranking'" class="title-with-icon icon-font icon-color_b icon_q icon-font_sm mt-3">{{ task.type }}</div>
                                                <p class="mt-5 pt-3 mt-md-0">
                                                   <a class="btn-pzu btn-pzu_small btn-pzu_blue-border"
                                                    v-if="task.type != 'Ranking'"
                                                    :href="'/zadania-specjalne/'+task.slug">WEŹ UDZIAŁ
                                                   </a>
                                                   <a class="btn-pzu btn-pzu_small btn-pzu_blue-border"
                                                    v-else
                                                    :href="'/zadania-specjalne/'+task.slug">ZOBACZ
                                                   </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useCMS from "../../../composables/frontend/cms";
import {nextTick, onMounted} from "vue";

export default {
    props: {
        section: {}
    },
    setup(ref) {
        const {specialTasksEditions, getSpecialTasksEditions} = useCMS()
        onMounted(() => getSpecialTasksEditions(3))
        return {
            specialTasksEditions,
        }
    },
}
</script>
