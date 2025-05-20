<template>
    <div class="card-results">
        <div class="title-header icon-font icon-color_g icon-font_lg" :class="icon_lg">{{title_lg}}</div>

        <div class="row mt-5 pt-4">
            <div class="col-md-6">
                <div class="title-with-icon icon-font icon-color_b icon_d icon-font_sm"><span>{{take_part}}</span> bierze udział</div>
            </div>
            <div class="col-md-6 pt-4 pt-md-0">
                <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm">Pozostało <span>{{left_day}}</span></div>
            </div>
        </div>

        <div v-if="month">
            <h5 class="pt-5">{{month}}</h5>
        </div>

        <div v-if="results_list">
            <ul class="results-list mt-5">
                <li>
                    <div class="score score_gold">1</div>
                    <div class="name">Jan Kowalski</div>
                </li>
                <li>
                    <div class="score score_grey">34</div>
                    <div class="name">Jan Kowalski</div>

                </li>
                <li class="bg-brown">
                    <div class="score score_brown">3</div>
                    <div class="name">Jan Kowalski</div>
                </li>
                <li class="bg-white">
                    <div class="score">5</div>
                    <div class="name">Jan Kowalski</div>
                    <div class="points points_granat">560.00 pkt.</div>
                </li>
                <li class="bg-granat">
                    <div class="score">5</div>
                    <div class="name">Jan Kowalski</div>
                    <div class="points points_white">160.00 pkt.</div>
                </li>
            </ul>

            <div v-if="link">
                <div v-if="spacer">
                    <p class="mt-6"></p>
                </div>
                <p class="pt-4"><a class="btn-pzu btn-pzu_blue-border" href="">ZOBACZ SZCZEGÓŁY</a></p>
            </div>
        </div>

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
                    <div class="swiper-results_box pb-4">
                        <div class="row">
                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">Akcja styczeń 2022</h5>
                                <div class="badge-pzu">Twój wynik: <span>516 755.52 APE</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">Akcja Sprzedażowa</div>
                                <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>2 450</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-results_box pb-4">
                        <div class="row">
                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">Akcja styczeń 2022</h5>
                                <div class="badge-pzu">Twój wynik: <span>516 755.52 APE</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">Akcja Sprzedażowa</div>
                                <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>2 450</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-results_box pb-4">
                        <div class="row">
                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">Akcja styczeń 2022</h5>
                                <div class="badge-pzu">Twój wynik: <span>516 755.52 APE</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">Akcja Sprzedażowa</div>
                                <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>2 450</span></div>
                            </div>
                        </div>
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="swiper-results_box pb-4">
                        <div class="row">
                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">Akcja styczeń 2022</h5>
                                <div class="badge-pzu">Twój wynik: <span>516 755.52 APE</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">Akcja Sprzedażowa</div>
                                <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>2 450</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-results_box pb-4">
                        <div class="row">
                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">Akcja styczeń 2022</h5>
                                <div class="badge-pzu">Twój wynik: <span>516 755.52 APE</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">Akcja Sprzedażowa</div>
                                <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>2 450</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-results_box pb-4">
                        <div class="row">
                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">Akcja styczeń 2022</h5>
                                <div class="badge-pzu">Twój wynik: <span>516 755.52 APE</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">Akcja Sprzedażowa</div>
                                <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>2 450</span></div>
                            </div>
                        </div>
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="swiper-results_box pb-4">
                        <div class="row">
                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">Akcja styczeń 2022</h5>
                                <div class="badge-pzu">Twój wynik: <span>516 755.52 APE</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">Akcja Sprzedażowa</div>
                                <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>2 450</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-results_box pb-4">
                        <div class="row">
                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">Akcja styczeń 2022</h5>
                                <div class="badge-pzu">Twój wynik: <span>516 755.52 APE</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">Akcja Sprzedażowa</div>
                                <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>2 450</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-results_box pb-4">
                        <div class="row">
                            <div class="col-md-12 d-block d-md-flex justify-content-between">
                                <h5 class="pt-2">Akcja styczeń 2022</h5>
                                <div class="badge-pzu">Twój wynik: <span>516 755.52 APE</span></div>
                            </div>
                            <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3">Akcja Sprzedażowa</div>
                                <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span>2 450</span></div>
                            </div>
                        </div>
                    </div>
                </swiper-slide>
            </swiper>

            <div v-if="link">
                <p class="pt-4"><a class="btn-pzu btn-pzu_blue-border" href="">ZOBACZ SZCZEGÓŁY</a></p>
            </div>
        </div>

    </div>
</template>

<script>
    import { Pagination } from 'swiper';
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import 'swiper/css/pagination';

    export default {
        components: {
            Swiper,
            SwiperSlide,
        },
        setup() {
            const onSwiper = (swiper) => {
                console.log(swiper);
            };
            const onSlideChange = () => {
                console.log('slide change');
            };
            return {
                onSwiper,
                onSlideChange,
                modules: [Pagination],
            };
        },
        props: {
            title_lg: String,
            icon_lg: String,
            take_part: String,
            left_day: String,
            link: String,
            month: String,
            results_list: Boolean,
            swiper: Boolean,
            spacer: Boolean
        }
    }
</script>