<template>
    <div class="card-results">
        <div class="title-header icon-font icon-color_g icon-font_lg" :class="icon_lg">{{title_lg}}</div>

        <div class="row pt-4">
            <div class="col-md-4 col-lg-3">
                <div class="floating-label">
                    <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="">
                        <option value=""></option>
                        <option value="1">Wszystkie</option>
                        <option value="2">Trwające</option>
                        <option value="3">Zakończone</option>
                    </select>
                    <span class="highlight"></span>
                    <label>Status</label>
                </div>
            </div>
        </div>
        <template v-for="duel in duels">
        <div class="new-entities">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col">
                            <h5>{{ duel.edition.category }}</h5>
                        </div>
                        <div class="col text-end">
                            <p class="small">Stan na dzień {{ currentDate() }}</p>
                        </div>
                    </div>

                    <div class="row pt-5">
                        <div class="col-4 col-md-2">
                            <img class="mt-4 img-fluid mx-auto d-block" src="/img/avatar.png">
                        </div>
                        <div class="col-8 col-md-3">
                            <div class="d-flex">
                                <div class="badge-pzu" :class="{'badge-pzu_grey': !isWinning(duel,1)}">{{duel.first_contender.wynik_msk}} pkt.</div>
                                <div class="icon-font icon-color_g icon_l icon-font_sm mt-3 ms-2" v-if="isWinning(duel,1)"></div>
                            </div>
                            <h5 class="pt-2">{{ duel.first_contender.msk }}</h5>
                            <h3>{{ duel.first_contender.region }}</h3>
                            <p class="pt-2"><a class="text-decoration-none cursor-pointer" data-bs-target="#osoby-w-zespole" data-bs-toggle="modal">Osoby w zespole</a></p>
                        </div>
                        <div class="col-12 col-md-2 pb-5 pb-md-0">
                            <div class="arrows"></div>
                        </div>
                        <div class="col-4 col-md-2">
                            <img class="mt-4 img-fluid mx-auto d-block" src="/img/avatar.png">
                        </div>
                        <div class="col-8 col-md-3">
                            <div class="d-flex">
                                <div class="badge-pzu" :class="{'badge-pzu_grey': !isWinning(duel,2)}">{{duel.second_contender.wynik_msk}} pkt.</div>
                                <div class="icon-font icon-color_g icon_l icon-font_sm mt-3 ms-2" v-if="isWinning(duel,2)"></div>
                            </div>
                            <h5 class="pt-2">{{ duel.second_contender.msk }}</h5>
                            <h3>{{ duel.second_contender.region }}</h3>
                            <p class="pt-2"><a class="text-decoration-none cursor-pointer" data-bs-target="#osoby-w-zespole" data-bs-toggle="modal">Osoby w zespole</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 line-left ps-5 pt-5">
                    <div class="title-with-icon title-with-icon_win icon-font icon-color_b icon_q icon-font_sm mt-4" v-if="isWinning(duel)">WYGRYWASZ!</div>
                    <div class="title-with-icon title-with-icon_lose icon-font icon-color_b icon_q icon-font_sm mt-4" v-else>PRZEGRYWASZ!</div>
                    <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-5">Czas trwania: <span>{{ duel.active_from}} - {{ duel.active_to }}</span></div>
                    <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5">Nagroda: <span>{{ duel.award }}</span></div>
                </div>
            </div>
        </div>
        </template>
        <!--<div class="new-entities">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col">
                            <h5>Liczba pozyskanych nowych podmiotów</h5>
                        </div>
                        <div class="col text-end">
                            <p class="small">Stan na dzień 12.08.2022</p>
                        </div>
                    </div>

                    <div class="row pt-5">
                        <div class="col-4 col-md-2">
                            <img class="mt-4 img-fluid mx-auto d-block" src="/img/Ellipse_41.png">
                        </div>
                        <div class="col-8 col-md-3">
                            <div class="d-flex">
                                <div class="badge-pzu">516 755.52 pkt.</div>
                                <div class="icon-font icon-color_g icon_l icon-font_sm mt-3 ms-2"></div>
                            </div>
                            <h5 class="pt-2">Adam Kowalski</h5>
                            <h3>Warszawa 2</h3>
                            <p class="pt-2"><a class="text-decoration-none cursor-pointer" data-bs-target="#osoby-w-zespole" data-bs-toggle="modal">Osoby w zespole</a></p>
                        </div>
                        <div class="col-12 col-md-2 pb-5 pb-md-0">
                            <div class="arrows"></div>
                        </div>
                        <div class="col-4 col-md-2">
                            <img class="mt-4 img-fluid mx-auto d-block" src="/img/Ellipse_42.png">
                        </div>
                        <div class="col-8 col-md-3">
                            <div class="d-flex">
                                <div class="badge-pzu badge-pzu_grey">516 755.52 pkt.</div>
                            </div>
                            <h5 class="pt-2">Arleta Malinowska</h5>
                            <h3>Gdynia</h3>
                            <p class="pt-2"><a class="text-decoration-none cursor-pointer" data-bs-target="#osoby-w-zespole" data-bs-toggle="modal">Osoby w zespole</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 line-left ps-5 pt-5">

                    <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-5">Czas trwania: <span>28.30 - 28.08</span></div>
                    <div class="title-with-icon icon-font icon-color_b icon_n icon-font_sm mt-5">Nagroda: <span>2 000 zł</span></div>
                </div>
            </div>
        </div>
        -->
    </div>

    <Modal
        id="osoby-w-zespole"
        title="Osoby w zespole"
    >
    </Modal>

</template>

<script>
import Modal from '../../../components/frontend/subcomponents/Modal'
import useCMS from "../../../composables/frontend/cms";
import {onMounted} from "vue";

export default {
    props: {
        section: {}
    },
    components: {
        Modal
    },
    setup() {
        const {user, getUserData} = useCMS()
        onMounted(() => getUserData())
        const { duels, getDuels } = useCMS()
        onMounted(() => getDuels() )
        function currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth() + 1}.${current.getFullYear()}`;
        }

        let icon_lg='icon_r'
        let title_lg='Pojedynki'
        return {
            icon_lg,
            user,
            currentDate,
            title_lg,
            duels,
        }
    },
    methods: {
        isWinning(duel,side=3) {
            if (side === 1) {
                return duel.first_contender.wynik_msk > duel.second_contender.wynik_msk;
            }
            if (side === 2) {
                return duel.first_contender.wynik_msk < duel.second_contender.wynik_msk;
            }
            if (side === 3) {
                return (this.user.nepu === duel.first_nepu && duel.first_contender.wynik_msk > duel.second_contender.wynik_msk) || (this.user.nepu == duel.second_nepu && duel.first_contender.wynik_msk < duel.second_contender.wynik_msk);
            }
        }
    }
}
</script>
