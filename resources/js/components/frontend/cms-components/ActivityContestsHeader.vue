<template>
    <div class="row">
        <div class="col">
            <div class="activity-box">
                <figure>
                    <img v-if="activityData.header" :src="activityData.header.file_path">
                </figure>
                <div class="activity-box_content">
                    <div class="row">
                        <div class="col text-end">
                            <p class="small">Stan na dzień {{ currentDate() }}</p>
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-12 col-md-8 d-block d-md-flex justify-content-between">
                            <div class="title-header icon-font icon-color_g icon_g icon-font_lg">{{  activityData.name }}</div>
                            <div class="title-with-icon icon-font icon-color_b icon_d icon-font_sm mt-5 mt-md-3"><span>0 osób</span> bierze udział</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted} from "vue";
import useCMS from "../../../composables/frontend/cms";

export default {
    props: {
        section: {
            required: true
        }
    },
    components: {
    },
    setup() {
        const { activityData, getActivityData } = useCMS()
        onMounted(() => getActivityData(4))
        function currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth() + 1}.${current.getFullYear()}`;
        }
        return {
            activityData,
            currentDate
        }
    },
}
</script>
