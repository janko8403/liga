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
                            <div class="title-header icon-font icon-color_g icon_c icon-font_lg">{{activityData.name}}</div>
                            <!--<div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-5 mt-md-3">
                                <span v-if="activityData.time_left>0">Do końca {{ activityData.time_left }} dni</span>
                                <span v-else-if="activityData.time_left<0">Zakończone</span>
                            </div>-->
                            <!--<div class="title-with-icon icon-font icon-color_b icon_d icon-font_sm mt-5 mt-md-3"><span>0 osób</span> bierze udział</div>-->
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
        section: {
            required: true
        }
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
            currentDate,
        }
    },
}
</script>
