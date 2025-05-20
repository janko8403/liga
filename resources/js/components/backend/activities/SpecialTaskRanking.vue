<template>
    <div class="h3 mb-3">
        <router-link :to="{ name: 'activities.editEdition', params: {id : task.edition_id, activity_id : '3' }}">
            <i class="fa-solid fa-chevron-left" style="color:#000"></i>
        </router-link>
        <span class="text-muted h3 ml-1"> Zadanie Specjalne Ranking</span>
    </div>

    <ActivityDataImport :show_export="true" type="ranking" :show_import="true" :edition_id="task.id" :activity_id="3"></ActivityDataImport>

    <RankingTable v-if="ranking" :data="ranking" :columns="columns"></RankingTable>


</template>

<script>
import {useToast} from 'bootstrap-vue-3';
import {nextTick, onMounted, ref} from 'vue';
import multiselect from 'vue-multiselect'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

import Files from '../files/FilesIndex'
import ActivityEditions from "./ActivityEditions";
import useActivitySpecialTasks from "../../../composables/backend/activity-special-tasks";
import RankingTable from "../elements/RankingTable";
import ActivityDataImport from "./ActivityDataImport";

export default {
    props: {
        task: {
            required: true,
        },
    },
    components : {
        ActivityEditions,
        ActivityDataImport,
        RankingTable,
        Datepicker,
        Files,
        multiselect,
    },
    setup(props) {
        const {errors, ranking, getRanking, updateRanking} = useActivitySpecialTasks()

        let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let file_type = 'attachment';
        let toast = useToast()
        let showInfo = () => {
            toast.show({title: errors })
        }
        let showNotify = (info) => {
            toast.show({title: info })
        }
        onMounted(() => getRanking(props.task.id))


        const date = ref(new Date())

        const saveRanking = async () => {
            await updateRanking(props.task.id)
            await nextTick()
            await showNotify("Zapisano dane")
        }

        return {
            errors,
            csrf,
            ranking,
            file_type,
            saveRanking,
            date,
            showInfo,
            columns: ['Uczestnik','Stanowisko','Wartość','Punkty'],
            rows: []
        }
    },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
