<template>
    <div class="container">
        <div class="row mt-3">
            <template v-if="sections && !taskslug && !contest_id" v-for="section in sections">
                <CMSSection :section="section"></CMSSection>
            </template>
            <template v-if="taskslug">
                <div v-if="specialTask.type === 'Ranking'">
                    <SpecialTaskRanking :task="specialTask"></SpecialTaskRanking>
                </div>
                <div v-if="specialTask.type === 'Quiz'">
                    <SpecialTaskQuiz :task="specialTask"></SpecialTaskQuiz>
                </div>
                <div v-if="specialTask.type === 'Zadanie Domowe'">
                    <SpecialTaskHomework :task="specialTask"></SpecialTaskHomework>
                </div>
                <div v-if="specialTask.type === 'Zadanie Opisowe'">
                    <SpecialTaskDescriptive :task="specialTask"></SpecialTaskDescriptive>
                </div>
            </template>
            <template v-if="contest_id">
                <ContestHeader :contest_id="contest_id"></ContestHeader>
                <Contest :contest_id="contest_id"></Contest>
            </template>
        </div>
    </div>
</template>

<script>
import useCMS from "../../composables/frontend/cms";
import {onMounted} from "vue";
import CMSSection from "./cms/CMSSection";
import SpecialTaskRanking from "./cms-components/SpecialTaskRanking";
import SpecialTaskQuiz from "./cms-components/ActivityQuiz";
import SpecialTaskHomework from "./cms-components/HomeworkTask";
import SpecialTaskDescriptive from "./cms-components/DescriptiveTask";
import Contest from "./cms-components/Contest"
import ContestHeader from "./cms-components/ContestHeader";

export default {
    props: {
       slug: {},
       taskslug: {},
       contest_id: {},
    },
    components: {
        ContestHeader,
        SpecialTaskDescriptive,
        SpecialTaskHomework,
        SpecialTaskQuiz,
        SpecialTaskRanking,
        CMSSection,
        Contest,
    },
    setup(props) {
        const {sections, getSections, getSpecialTask, specialTask} = useCMS()

        if (props.taskslug) {
            onMounted(() => getSpecialTask(props.taskslug));
        }
        else if (props.contest_id) {

        }
        else {
            onMounted(() => getSections(props.slug))
        }

        return {
            sections,
            specialTask,
        }
    }
}
</script>
