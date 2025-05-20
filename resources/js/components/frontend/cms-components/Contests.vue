<template>
    <div class="row">
        <ContestsHeader></ContestsHeader>
        <div class="col">
            <div class="card-results">
                <h2 class="pb-4">Konkursy / Akcje</h2>
                <div class="row">
                    <template v-for="contest in contests">
                    <div class="col-md-12 col-lg-6">
                        <div class="swiper-results_box">
                            <div class="row">
                                <div class="col-md-12 d-block d-md-flex justify-content-between">
                                    <h5 class="pt-2">{{ contest.name }}</h5>
                                    <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-5 mt-md-3">
                                        <span v-if="contest.time_left>0">Do końca {{ contest.time_left }} dni</span>
                                        <span v-else-if="contest.time_left<0">Zakończone</span>
                                    </div>
                                    <div class="badge-pzu">Twój wynik: <span v-if="contest.wartosc">{{ contest.wartosc }}</span><span v-else>Brak</span></div>
                                </div>
                                <div class="col-md-12 pt-5 d-block d-md-flex justify-content-between">
                                    <div class="title-with-icon icon-font icon-color_b icon_c icon-font_sm mt-3" :class="{'icon_k':contest.type == 'Konkurs'}">{{ contest.type }}</div>
                                    <div v-if="contest.nagroda" class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5 mt-md-3">Nagroda: <span >{{ contest.nagroda }}</span></div>
                                    <p class="mt-5 pt-3 mt-md-0"><a class="btn-pzu btn-pzu_small btn-pzu_blue-border" :href="'/konkursy-i-akcje-sprzedazowe/'+contest.id">szczegóły</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useCMS from "../../../composables/frontend/cms";
import {onMounted} from "vue";
import ContestsHeader from "./ContestsHeader";

export default {
    components: {
        ContestsHeader,
    },
    props: {
        section: {
            required: true
        }
    },
    setup() {
        const { contests, getContests } = useCMS()
        onMounted(() => getContests(4))

        return {
            contests,
        }
    },
}
</script>
