<template>
    <swiper
        class="swiper-header"
        :spaceBetween="30"
        :effect="'fade'"
        :navigation="true"
        :pagination="{ clickable: true }"
        :modules="modules"
    >
        <swiper-slide>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Example headline 1</h1>
                        <h2 class="pt-3 pb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
                        <p class="pt-5"><a class="btn-pzu btn-pzu_blue" href="#">zobacz aktywności</a></p> 
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <img class="img-fluid" src="/img/header.png">
                    </div>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Example headline 2</h1>
                        <h2 class="pt-3 pb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
                        <p class="pt-5"><a class="btn-pzu btn-pzu_blue" href="#">zobacz aktywności</a></p>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <img class="img-fluid" src="/img/header.png">
                    </div>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Example headline 3</h1>
                        <h2 class="pt-3 pb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
                        <p class="pt-5"><a class="btn-pzu btn-pzu_blue" href="#">zobacz aktywności</a></p>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <img class="img-fluid" src="/img/header.png">
                    </div>
                </div>
            </div>
        </swiper-slide>
    </swiper>
</template>

<script>
    import { Swiper, SwiperSlide } from "swiper/vue";
    import "swiper/css";
    import "swiper/css/effect-fade";
    import "swiper/css/pagination";

    import { EffectFade, Pagination } from "swiper";

    export default {
        components: {
            Swiper,
            SwiperSlide,
        },
        setup() {
            return {
                modules: [Pagination],
            };
        },
    };
</script>