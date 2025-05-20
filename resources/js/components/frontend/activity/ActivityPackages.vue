<template>
    <div class="container">

        <div class="row">
            <div class="col">
                <BreadCrumb></BreadCrumb>
            </div>
        </div>

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
                            <div class="col-12 col-md-12 col-lg-10 d-block d-md-flex justify-content-between">
                                <div class="title-header">QUIZ Pakiety dodatkowe PNŻ
                                </div>
                                <div class="title-with-icon icon-font icon-color_b icon_p icon-font_sm mt-5 mt-md-3">
                                    Quiz
                                </div>
                                <div class="title-with-icon icon-font icon-color_b icon_d icon-font_sm mt-5 mt-md-3">
                                    <span>33osób</span> bierze udział <span>z 80 uprawnionych</span>
                                </div>
                                <div class="title-with-icon icon-font icon-color_b icon_e icon-font_sm mt-5 mt-md-3">
                                    Pozostało <span>7 dni</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 d-block d-md-flex justify-content-end">
                                <p class="mt-5 pt-3 mt-md-0"><a class="btn-pzu btn-pzu_blue-border" href="">RANKING</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <Accordion id='liga-2' name="Sposób przyznawania punktów" show content>
                </Accordion>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card-results">

                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between">
                            <h2>Ranking zadania</h2>

                            <a class="text-decoration-none mt-2" href="/">
                                <div class="icon-font icon-color_g icon_u icon-font_lg">Regulamin.pdf</div>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-lg-3">
                            <div class="floating-label">
                                <select class="floating-select floating-select_active"
                                    onclick="this.setAttribute('value', this.value);" value="">
                                    <option value=""></option>
                                    <option value="1">Trwające</option>
                                    <option value="2">Zakończone</option>
                                </select>
                                <span class="highlight"></span>
                                <label>Dane MSK</label>
                            </div>
                        </div>
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
                            <LoaderTable />
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import BreadCrumb from '../../../components/frontend/subcomponents/BreadCrumb'
import Accordion from '../../../components/frontend/subcomponents/Accordion'
import LoaderTable from '../../../components/frontend/subcomponents/LoaderTable'
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
        BreadCrumb,
        Accordion,
        LoaderTable,
        DataTable,
        Select
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
@import 'datatables.net-dt';
</style>
