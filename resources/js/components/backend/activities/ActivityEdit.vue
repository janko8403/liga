<template>
    <div v-if="activity.type == 1 || activity.type == 2">
        <ActivityLeaguesEdit :id="id" :activity="activity"></ActivityLeaguesEdit>
    </div>
    <div v-if="activity.type == 3">
        <ActivitySpecialTasksEdit :id="id"></ActivitySpecialTasksEdit>
    </div>
    <div v-if="activity.type == 4">
        <ActivityContestsEdit :id="id" :activity="activity"></ActivityContestsEdit>
    </div>
</template>

<script>
import useActivities from '../../../composables/backend/activities'
import { onMounted } from 'vue';
import ActivityLeaguesEdit from "./ActivityLeaguesEdit";
import ActivitySpecialTasksEdit from "./ActivitySpecialTasksEdit";
import ActivityContestsEdit from "./ActivityContestsEdit";

export default {
    components: {
        ActivityContestsEdit,
        ActivitySpecialTasksEdit,
        ActivityLeaguesEdit
    },
    props: {
        id: {
            required: true,
            type: String,
        },
    },
    setup(props) {
        const { activity, getActivity } = useActivities()
        onMounted(() => getActivity(props.id))
        return {
            activity,
        }
    }
}
</script>
