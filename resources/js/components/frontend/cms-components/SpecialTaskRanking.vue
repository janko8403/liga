<template>
    <ul class="breadcrumb">
        <li><a href="/">Strona główna</a></li>
        <li><a href="/zadania-specjalne">Zadania Specjalne</a></li>
        <li>{{ task.name }}</li>
    </ul>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="activity-box">
                    <div class="activity-box_content">
                        <div class="row">
                            <div class="col text-end">
                                <p class="small">Stan na dzień 12.08.2022</p>
                            </div>
                        </div>
                        <div class="row pb-5">
                            <div class="col-12 col-md-8 d-block d-md-flex justify-content-between">
                                <div class="title-header">{{ task.name }}</div>
                                <!--<div class="title-with-icon icon-font icon-color_b icon_d icon-font_sm mt-5 mt-md-3">
                                    <span>0 osób</span> bierze udział
                                 </div>-->
                                <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-3">
                                    <span v-if="task.time_left>0">Do końca {{ task.time_left }} dni</span>
                                    <span v-else-if="task.time_left<0">Zakończone</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 d-block d-md-flex justify-content-end">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card-results">

                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between">
                            <h2>Ranking zadania</h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <DataTable class="mini-table" width="100%" :data="data" :options="{select: false}">
                                <thead>
                                    <tr>
                                        <th>Pozycja</th>
                                        <th>Dane MSK</th>
                                        <th>Punkty</th>
                                        <th>Nagroda</th>
                                    </tr>
                                </thead>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Accordion from '../subcomponents/Accordion'
import Preloader from '../subcomponents/Preloader'
import DataTable from 'datatables.net-vue3'
import Select from 'datatables.net-select'
import $ from 'jquery'
import useCMS from "../../../composables/frontend/cms";
import {onMounted} from "vue";

const data = [
    ['<div class="score-table score-table_gold">1</div>', 'Adam das', '<div class="badge-pzu badge-pzu_granat">280.00 pkt.</div>', '<div class="star-win">m</div>'],
    ['<div class="score-table score-table_grey">2</div>', 'Adam Kowalski', '<div class="badge-pzu badge-pzu_granat">280.00 pkt.</div>', '<div class="star-win">m</div>'],
    ['<div class="score-table score-table_brown">3</div>', 'Adam Jankowski', '<div class="badge-pzu badge-pzu_granat">280.00 pkt.</div>', '<div class="star-win">m</div>'],
    ['<div class="score-table score-table_granat">4</div>', 'Adam Jankowski', '<div class="badge-pzu badge-pzu_granat">280.00 pkt.</div>', '<div class="star-win">m</div>'],
];

export default {
    props: {
        task: {
            required: true
        }
    },
    components: {
        Accordion,
        DataTable,
        Select
    },
    setup(props) {
        const { specialTask, activityUsers, getSpecialTask, getActivityUsers } = useCMS()
        onMounted(() => getSpecialTask(props.task.slug))

        function currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth() + 1}.${current.getFullYear()}`;
        }

        return {
            currentDate,
            specialTask,
        }
    },
    data() {
        return {
            data
        }
    },
    mounted() {
        $('#DataTables_Table_0').DataTable({
            createdRow: function (row, data, dataIndex) {
                if (dataIndex == 3) {
                    $(row).addClass('active_table');
                }
            }
        });
    }
}
</script>

<style>
@import '/node_modules/datatables.net-dt';
</style>
