<template>
    <div class="card-results">
        <div class="title-header icon-font icon-color_g icon-font_lg" :class="icon_lg">{{title_lg}}</div>
         <div v-if="swiper">
            <swiper
                class="swiper-results"
                :modules="modules"
                :slides-per-view="1"
                :pagination="{ clickable: true}"
                @swiper="onSwiper"
                @slideChange="onSlideChange"
            >
                <swiper-slide>
                    <template v-for="contest in contests">
                    <div class="swiper-results_box pb-4">
                        <div class="row">

                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">{{  contest.name }}</h5>
                                <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-5 mt-md-3">
                                    <span v-if="contest.time_left>0">Do końca {{ contest.time_left }} dni</span>
                                    <span v-else-if="contest.time_left<0">Zakończone</span>
                                </div>
                                <div class="badge-pzu">Twój wynik: <span v-if="contest.wartosc">{{ contest.wartosc }}</span><span v-else>Brak</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">{{contest.type}}</div>
                                <div v-if="contest.nagroda" class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>{{contest.nagroda}}</span></div>
                            </div>
                        </div>
                    </div>
                    </template>
                </swiper-slide>
            </swiper>

            <div v-if="link">
                <p class="pt-4"><a class="btn-pzu btn-pzu_blue-border" :href="link">ZOBACZ SZCZEGÓŁY</a></p>
            </div>
        </div>

    </div>
</template>

<script>
    import { Pagination } from 'swiper';
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import 'swiper/css/pagination';
    import useCMS from "../../../composables/frontend/cms";
    import {onMounted} from "vue";

    export default {
        components: {
            Swiper,
            SwiperSlide,
        },
        setup() {
            const { contests, getContests, activityInfo, getActivityInfo } = useCMS()
            onMounted(() => getContests(4))
            onMounted(() => getActivityInfo(4))
            const onSwiper = (swiper) => {
            };
            const onSlideChange = () => {
            };
            return {
                swiper: true,
                contests,
                activityInfo,
                icon_lg:'icon_c',
                title_lg:'Konkursy i Akcje Sprzedażowe',
                take_part:"0 osób",
                left_day:"0 dni",
                link:"/konkursy-i-akcje-sprzedazowe",
                onSwiper,
                onSlideChange,
                modules: [Pagination],
            };
        },
    }
</script>
