<template>
    <ul class="breadcrumb ms-1">
        <li><a href="/">Strona główna</a></li>
        <li><a href="/konkursy-i-akcje-sprzedazowe">Konkursy i Akcje Sprzedażowe</a></li>
        <li>{{ contest.name }}</li>
    </ul>
    <div class="row">
        <div class="col">
            <div class="activity-box">
                <div class="activity-box_content">
                    <div class="row">
                        <div class="col text-end">
                            <p class="small">Stan na dzień 12.08.2022</p>
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-12 col-md-12 col-lg-10 d-block d-md-flex justify-content-between">
                            <h2>{{  contest.name }}</h2>
                            <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-5 mt-md-3">{{ contest.type }}</div>
                            <div class="title-with-icon icon-font icon-color_b icon_d icon-font_sm mt-5 mt-md-3">
                                osoby biorące udział
                                <span v-if="activityInfo.users">{{ activityInfo.users }}</span>
                                <span v-else>0</span>
                            </div>
                            <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-5 mt-md-3">
                                <span v-if="contest.time_left>0">Do końca {{ contest.time_left }} dni</span>
                                <span v-else-if="contest.time_left<0">Zakończone</span>
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
import {onMounted} from "vue";

export default {
    components: {
    },
    props: {
        contest_id: {
            required: true
        }
    },
    setup(props) {
        const { contest, getContest, activityInfo, getActivityInfo } = useCMS()
        onMounted(() => getContest(props.contest_id))
        onMounted(() => getActivityInfo(4,props.contest_id))

        return {
            contest,
            activityInfo,
        }
    },
}
</script>
