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
                            <div class="title-header icon-font icon-color_g icon_f icon-font_lg">{{activityData.name}}</div>
                            <div class="title-with-icon icon-font icon-color_b icon_d icon-font_sm mt-5 mt-md-3"><span>osoby biorące udział {{ activityInfo.users }}</span></div>
                            <!--<div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-5 mt-md-3">Pozostało <span>7 dni</span></div>-->
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-12 col-md-12 d-block d-md-flex justify-content-between">
                            <p class="pt-4">Twoja pozycja w rankingu
                                <span v-if="activityInfo.place">{{ activityInfo.place }}</span>
                                <span v-else>Brak</span>
                            </p>
                          <!--  <p class="pt-4">Do pozycji premiowanej brakuje Ci <span>85.00</span> punktów!</p>-->
                            <p class="mt-5 pt-3 mt-md-0"><a class="btn-pzu btn-pzu_blue-border" href="#ranking">RANKING</a></p>
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
        const { activityData, activityInfo, getActivityData, getActivityInfo } = useCMS()
        onMounted(() => getActivityInfo(2))
        onMounted(() => getActivityData(2))
        function currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth() + 1}.${current.getFullYear()}`;
        }
        return {
            activityData,
            activityInfo,
            currentDate,
        }
    },
}
</script>
