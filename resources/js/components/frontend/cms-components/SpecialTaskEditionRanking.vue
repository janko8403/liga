<template>
    <div class="row">
        <div class="col">
            <div class="card-results">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <h2>Ranking wszystkich zadań</h2>
                        <!--<a class="text-decoration-none mt-2" href="/">
                            <div class="icon-font icon-color_g icon_u icon-font_lg">Regulamin.pdf</div>
                        </a>-->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-4">
                        <DataTable
                            class="mini-table"
                            width="100%"
                            :data="data"
                            :options="{select: false}"
                        >
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
</template>

<script>
import Accordion from '../../../components/frontend/subcomponents/Accordion'
import DataTable from 'datatables.net-vue3'
import Select from 'datatables.net-select'
import $ from 'jquery'

const data = [
    ['<div class="score-table score-table_gold">1</div>', 'Adam Nowak', '<div class="badge-pzu badge-pzu_granat">280.00 pkt.</div>', '<div class="star-win">m</div>'],
    ['<div class="score-table score-table_grey">2</div>', 'Adam Kowalski', '<div class="badge-pzu badge-pzu_granat">280.00 pkt.</div>', '<div class="star-win">m</div>'],
    ['<div class="score-table score-table_brown">3</div>', 'Adam Jankowski', '<div class="badge-pzu badge-pzu_granat">280.00 pkt.</div>', '<div class="star-win">m</div>'],
    ['<div class="score-table score-table_granat">4</div>', 'Adam Jankowski', '<div class="badge-pzu badge-pzu_granat">280.00 pkt.</div>', '<div class="star-win">m</div>'],
];

export default {
    components: {
        Accordion,
        DataTable,
        Select
    },
    data() {
        return {
            data
        }
    },
    mounted() {
        $('#DataTables_Table_0').DataTable( {
            createdRow: function( row, data, dataIndex ) {
                if(dataIndex == 3 ) {
                    $( row ).addClass('active_table');
                }
            }
        } );
    }
}
</script>
<style>
@import 'datatables.net-dt';
</style>
