<template>
    <div class="card-results">
        <div class="title-header icon-font icon-color_g icon-font_lg" :class="icon_lg">{{title_lg}}</div>

        <div class="row mt-5 pt-4">
            <div class="col-md-6">
                <div class="title-with-icon icon-font icon-color_b icon_d icon-font_sm mt-5 mt-md-3"><span>{{ activityInfo.users }} bierze udział</span></div>
            </div>
        </div>

        <div v-if="results_list">
            <ul class="results-list mt-5">
                <li v-for="result in activityResults" :class="[user.name.toUpperCase()+' '+user.lastname.toUpperCase() == result[1].toUpperCase()?'bg-granat':'']">
                    <div class="score score_gold" v-if="result[0] == 1">{{ result[0]}}</div>
                    <div class="score score_grey" v-if="result[0] == 2">{{ result[0]}}</div>
                    <div class="score score_brown" v-if="result[0] == 3">{{ result[0] }}</div>
                    <div class="score score_clean">{{ result[0]}}</div>
                    <div class="name">{{ result[1] }}</div>
                    <div class="points points_granat">{{ result[4] }}</div>
                </li>
            </ul>

            <div v-if="link">
                <p class="pt-5 mt-2"><a class="btn-pzu btn-pzu_blue-border" href="/liga-mistrzow-cash">ZOBACZ SZCZEGÓŁY</a></p>
            </div>
        </div>
    </div>
</template>

<script>
import useCMS from "../../../composables/frontend/cms";
import {onMounted} from "vue";

export default {
    components: {
    },
    setup() {
        const { activityData, activityResults, user, getUserData, activityInfo, getActivityInfo, getActivityResults, getActivityData } = useCMS()
        onMounted(() => getActivityData(2))
        onMounted(() => getUserData())
        onMounted(() => getActivityInfo('2'))
        onMounted(() => getActivityResults('2',5))

        return {
            activityData,
            activityInfo,
            user,
            activityResults,
            icon_lg:'icon_f',
            title_lg:'Liga Mistrzów Cash',
            take_part:"0 osób",
            left_day:"0 dni",
            link:"/link",
            results_list:true,
            ja: '',
        };
    },
}
</script>
