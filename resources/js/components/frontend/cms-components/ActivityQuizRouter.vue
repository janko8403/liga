<template>
    <template v-if="!isFinished">
        <ActivityQuiz></ActivityQuiz>
    </template>
    <template v-if="isFinished">
        <ActivityQuizFinish></ActivityQuizFinish>
    </template>
</template>

<script>
import ActivityQuiz from "./ActivityQuiz";
import ActivityQuizFinish from "./ActivityQuizFinish";

export default {
    props: {
        quiz,
    },
    components: {
        ActivityQuiz,
        ActivityQuizFinish
    },
    computed: {
        isFinished() {
            return false;
        }
    }
}
</script>
