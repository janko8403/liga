<template>
    <div class="row" id="ranking">
        <div class="col">
            <div class="card-results">

                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <h2>Ranking Liga mistrzów Cash</h2>

                        <a class="text-decoration-none mt-2" href="/api/frontend/data-export/2">
                            <div class="icon-font icon-color_g icon_u icon-font_lg">Ranking</div>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-4">
                        <DataTable
                            class="display"
                            width="100%"
                            :data="activityResults.length == 0?[['','','','','','','','','']]:activityResults"
                            :options="{select: false}"
                        >
                            <thead>
                            <tr>
                                <th>Pozycja</th>
                                <th>Uczestnik</th>
                                <th>K1</th>
                                <th>K2</th>
                                <th>Punkty</th>
                            </tr>
                            </thead>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Accordion from '../../../components/frontend/subcomponents/Accordion'
import Preloader from '../../../components/frontend/subcomponents/Preloader'
import DataTable from 'datatables.net-vue3'
import Select from 'datatables.net-select'
import $ from 'jquery'
import useCMS from "../../../composables/frontend/cms";
import {nextTick, onMounted} from "vue";

export default {
    components: {
        Accordion,
        DataTable,
        Select
    },
    props: {
        section: {
            required: true
        }
    },
    setup() {
        const { activityResults, getActivityResults, topResults, getActivityTopResults, user, getUserData } = useCMS()
        onMounted(() => initSection() )

        let reinitSection = async (event) => {
            let table = $('#DataTables_Table_0').DataTable();
            await table.destroy();
            await nextTick()
            await initSection()
        }

        let initSection = async () => {
            await getActivityResults('2',1000)
            await nextTick();
            await getUserData()
            await nextTick();
            await getActivityTopResults('2')
            await nextTick();
            await $('#DataTables_Table_0').DataTable({
                paging: false,
                createdRow: function (row, data, dataIndex) {
                    if (row.cells[1].innerHTML.toUpperCase() == user.value.name.toUpperCase()+' '+user.value.lastname.toUpperCase())
                    {
                        $(row).addClass('active_table');
                    }
                    let v=2;
                    let i = 0;
                    topResults.value.columns.forEach(e => {
                        if (typeof(topResults.value[e][0])!="undefined") {
                            if (row.cells[v].innerHTML == topResults.value[e][0][e]) {
                                row.cells[v].innerHTML = '<div class="badge-pzu badge-pzu_gold">'+ row.cells[v].innerHTML +'</div>';
                                i++;
                            }
                        }
                        if (typeof(topResults.value[e][1])!="undefined") {
                            if (row.cells[v].innerHTML == topResults.value[e][1][e]) {
                                row.cells[v].innerHTML = '<div class="badge-pzu badge-pzu_grey">' + row.cells[v].innerHTML + '</div>';
                                i++;
                            }
                        }
                        if (typeof(topResults.value[e][2])!="undefined") {
                            if (row.cells[v].innerHTML == topResults.value[e][2][e]) {
                                row.cells[v].innerHTML = '<div class="badge-pzu badge-pzu_brown">' + row.cells[v].innerHTML + '</div>';
                                i++;
                            }
                        }
                        if (i === 0) {
                            row.cells[v].innerHTML = '<div class="badge-pzu badge-pzu_clean">' + row.cells[v].innerHTML + '</div>';
                        } else {
                            i=0;
                        }
                        v++;
                    })

                    switch (row.cells[0].innerHTML) {
                        case '1':
                            row.cells[0].innerHTML = '<div class="score-table score-table_gold">1</div>';
                            break;
                        case '2':
                            row.cells[0].innerHTML = '<div class="score-table score-table_grey">2</div>';
                            break;
                        case '3':
                            row.cells[0].innerHTML = '<div class="score-table score-table_brown">3</div>';
                            break;
                        default:
                            row.cells[0].innerHTML = '<div class="score-table">' + row.cells[0].innerHTML + '</div>';
                            break;
                    }

                    row.cells[4].innerHTML = '<div class="badge-pzu badge-pzu_granat">' + row.cells[4].innerHTML + ' pkt.</div>';
                    if (!row.cells[4]) {row.cells[3].innerHTML = '<div class="badge-pzu badge-pzu_granat">' + row.cells[3].innerHTML + ' pkt.</div>';}                }
            })
        }

        return {
            reinitSection,
            activityResults,
        }
    },
    methods: {
        getDataIndex(name) {
            return this.section.data.findIndex(p => p.name === name)
        },
        sData(name) {
            let index = this.getDataIndex(name)
            if (index >= 0) {
                let row = this.section.data[index]
                return (row.value)
            }
        },
        vData(name) {
            let row = JSON.parse(this.section.component.labels);
            return row[name]
        },
    },
}
</script>

<style>
@import 'datatables.net-dt';
</style>
