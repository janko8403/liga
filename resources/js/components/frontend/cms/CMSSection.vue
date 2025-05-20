<template>
    <div :class="'mt-5 col-'+section.columns">
        <component v-if="section.id" v-bind:is="section.component.component_path" :section="section"></component>
    </div>
</template>
<script>

import TextSection from '../cms-components/base/TextSection.vue';
import ImageSection from '../cms-components/base/ImageSection';
import RichTextSection from '../cms-components/base/RichTextSection';
import MainHeaderSwiper from "../cms-components/MainHeaderSwiper";
import ActivityLeagueHeader from "../cms-components/ActivityLeagueHeader";
import ActivityLeagueTable from "../cms-components/ActivityLeagueTable";
import ActivityLeagueRules from "../cms-components/ActivityLeagueRules";
import AboutSection from "../cms-components/AboutSection";
import ActivityCashBoxResults from "../cms-components/ActivityCashBoxResults";
import ActivityCashLeagueHeader from "../cms-components/ActivityCashLeagueHeader";
import ActivityCashLeagueRules from "../cms-components/ActivityCashLeagueRules";
import ActivityCashLeagueTable from "../cms-components/ActivityCashLeagueTable";
import ActivityLeagueBoxResults from "../cms-components/ActivityLeagueBoxResults";
import ContestsHeader from "../cms-components/ContestsHeader";
import ContestHeader from "../cms-components/ContestHeader";
import Contests from "../cms-components/Contests";
import Duels from "../cms-components/Duels";
import DuelsDescription from "../cms-components/DuelsDescription";
import DuelsHeader from "../cms-components/DuelsHeader";
import Map from "../cms-components/Map";
import SpecialTaskHeader from "../cms-components/SpecialTaskHeader";
import SpecialTaskEditions from "../cms-components/SpecialTaskEditions";
import SpecialTaskPrizes from "../cms-components/SpecialTaskPrizes";
import SpecialTaskEditionRanking from "../cms-components/SpecialTaskEditionRanking";
import RichTextBordered from "../cms-components/base/RichTextBordered";
import BreadCrumbs from "../cms-components/base/BreadCrumbs";
import ImageText from "../cms-components/base/ImageText";
import TextImage from "../cms-components/base/TextImage";
import ActivityContestBoxResults from "../cms-components/ActivityContestBoxResults";

export default {
    components: {
        AboutSection,
        ActivityCashBoxResults,
        ActivityContestBoxResults,
        ActivityCashLeagueRules,
        SpecialTaskPrizes,
        SpecialTaskEditions,
        SpecialTaskEditionRanking,
        SpecialTaskHeader,
        ContestHeader,
        BreadCrumbs,
        Map,
        DuelsHeader,
        DuelsDescription,
        Duels,
        Contests,
        ContestsHeader,
        ActivityLeagueBoxResults,
        ActivityCashLeagueTable,
        ActivityCashLeagueHeader,
        TextSection,
        ImageText,
        TextImage,
        RichTextSection,
        RichTextBordered,
        ImageSection,
        MainHeaderSwiper,
        ActivityLeagueHeader,
        ActivityLeagueTable,
        ActivityLeagueRules,

    },
    props: {
        section: {
            required: true
        }
    },
}
</script>

