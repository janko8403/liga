<template>
    <swiper
        class="swiper-header"
        :spaceBetween="30"
        :effect="'fade'"
        :navigation="true"
        :pagination="{ clickable: true }"
        :modules="modules"
    >
        <swiper-slide v-if="sData('title1')">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1>{{ sData("title1") }}</h1>
                        <h2 class="pt-3 pb-4">{{ sData("subtitle1")}}</h2>
                        <p>{{ sData("content1")}}</p>
                        <p class="pt-5"><a class="btn-pzu btn-pzu_blue" :href="sData('url1')">zobacz aktywności</a></p>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <img class="img-fluid" src="/img/header.png">
                    </div>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide v-if="sData('title2')">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1>{{ sData("title2") }}</h1>
                        <h2 class="pt-3 pb-4">{{ sData("subtitle2")}}</h2>
                        <p>{{ sData("content2") }}</p>
                        <p class="pt-5"><a class="btn-pzu btn-pzu_blue" :href="sData('url2')">zobacz aktywności</a></p>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <img class="img-fluid" src="/img/header.png">
                    </div>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide v-if="sData('title3')">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1>{{ sData("title3") }}</h1>
                        <h2 class="pt-3 pb-4">{{ sData("subtitle3")}}</h2>
                        <p>{{ sData("content3") }}</p>
                        <p class="pt-5"><a class="btn-pzu btn-pzu_blue" :href="sData('url3')">zobacz aktywności</a></p>
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
        props: {
            section: {
                required: true
            }
        },
        methods: {
            getDataIndex(name) {
                return this.section.data.findIndex(p => p.name === name)
            },
            sData(name) {
                let index = this.getDataIndex(name)
                if (index >= 0) {
                    let row = this.section.data[index]
                    return (row.value)
                }
            },
            vData(name) {
                let row = JSON.parse(this.section.component.labels);
                return row[name]
            },
        }
    };
</script>
