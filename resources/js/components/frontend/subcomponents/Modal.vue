<template>
    <div class="modal fade" :id="id" tabindex="-1" aria-labelledby="osoby-1-Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-end">
                    <button type="button" class="btn-close-pzu" data-bs-dismiss="modal" aria-label="Close">i</button>
                </div>
                <div class="modal-body">
                    <div class="title">{{title}}</div>
                    <div v-if="!team">
                        <div class="row">
                            <div class="col-3 col-md-2">
                                <img class="mt-4 img-fluid mx-auto d-block" src="/img/avatar.png">
                            </div>
                            <div class="col-9 col-md-4">
                                <h5 class="mt-1 mb-0 pt-4"><span>{{  user.name }}</span> <span> {{  user.lastname }}</span></h5>
                                <h3>{{  user.region }}</h3>
                            </div>
                        </div>

                        <div class="row pt-5">
                            <div class="col">
                                <div class="sort-by">Dane MSK</div>
                                <div class="scroll-results">
                                    <ul class="results-list results-list_modal">
                                        <!--<li>
                                            <div class="name">Jan Kowalski</div>
                                        </li>
                                        <li>
                                            <div class="name">Jan Kowalski</div>

                                        </li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="team">
                        <div class="row">
                            <div class="col-3 col-md-2">
                                <img class="mt-4 img-fluid mx-auto d-block" src="/img/avatar.png">
                            </div>
                            <div class="col-5 col-md-3">
                                <h5 class="mt-1 mb-0 pt-4"></h5>
                                <h3></h3>
                            </div>
                            <div class="col-4 col-md-7">
                                <div class="mt-5 badge-pzu float-end"><span>0 pkt.</span></div>
                            </div>
                        </div>

                        <div class="row pt-5">
                            <div class="col">
                                <div class="row">
                                    <div class="col-3 col-md-3">
                                        <div class="sort-by">Pozycja</div>
                                    </div>
                                    <div class="col-4 col-md-3">
                                        <div class="sort-by">Dane MSK</div>
                                    </div>
                                    <div class="col-3 offset-1 col-md-3 offset-md-3">
                                        <div class="sort-by">Punkty</div>
                                    </div>
                                </div>
                                <div class="scroll-results">
                                    <ul class="results-list results-list_modal results-list_sortby">
                                        <li class="bg-white">
                                            <div class="score">1</div>
                                            <div class="name">{{  user.name }} {{  user.lastname }}</div>
                                            <div class="points points_granat">0 pkt.</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <button type="button" class="btn-pzu btn-pzu_blue mt-5" data-bs-dismiss="modal">zamknij</button>
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
        props: {
            id: String,
            title: String,
            team: {},
        },
        setup() {
            const {user, getUserData} = useCMS()
            onMounted(() => getUserData())
            return {
                user,
            }
        },
    }
</script>
