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

        <div v-if="results_list">
            <ul class="results-list mt-5">
            </ul>

            <div v-if="link">
                <p class="pt-5 mt-6"><a class="btn-pzu btn-pzu_blue-border" href="/zadania-specjalne">ZOBACZ SZCZEGÓŁY</a></p>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        components: {
        },
        setup() {
            return {
                icon_lg:'icon_f',
                title_lg:'Zadania Specjalne',
                take_part:"0 osób",
                left_day:"0 dni",
                link:"/zadania-specjalne",
                results_list:true,
            };
        },
    }
</script>
