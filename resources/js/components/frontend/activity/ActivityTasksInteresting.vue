<template>
    <div class="container">

        <div class="row">
            <div class="col">
                <BreadCrumb></BreadCrumb>
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

                    <div class="row pb-5">
                        <div class="col-md-12 col-lg-6 offset-lg-3">
                            <div class="icon-font icon-font_no_content icon-color_g text-center pt-5 pb-5">b</div>
                            <h2 class="text-center">Już wykonałeś zadanie!</h2>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div class="row">
            <div class="col">
                <div class="card-results">

                    <div class="row pb-5">
                        <div class="col-md-12 col-lg-6 offset-lg-3">
                            <div class="icon-font icon-font_no_content icon-color_g text-center pt-5 pb-5">b</div>
                            <h2 class="text-center">Już wykonałeś zadanie!</h2>

                            <p class="text-center pt-4">Czekamy na wyniki</p>
                        </div>
                    </div>
        <div class="row">
            <div class="col">
                <div class="card-results">
        
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Zadanie domowe</h2>
                            
                            <p class="pt-5">Quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem
                            vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum
                            fugiat quo voluptas nulla pariatur?"</p>

                            <form class="pt-3" ref="form">
                                <textarea class="blue-border mb-0"></textarea>
                                <p class="pt-3">Ilość pozostałych znaków: 250</p>

                                <p class="small"></p>

                                <div class="upload-container pt-5">
                                    <ul id="fileList" class="file-list"></ul>
                                    <div class="upload-file">
                                        <input
                                            type="file" 
                                            class="upload-file-input" 
                                            id="file" 
                                            @change="previewFiles" 
                                            accept="application/pdf"
                                        >
                                        <label class="upload-file-label" for="file">DODAJ ZAŁĄCZNIK</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col d-block d-md-flex justify-content-end">
                                        <button class="btn-pzu btn-pzu_blue">Wyślij</button>
                                    </div>
                                </div>
                            </form>
                            
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
    },
    methods: {
        previewFiles() {
            var input = document.getElementById('file');
            var output = document.getElementById('fileList');
            var children = "";
            for (var i = 0; i < input.files.length; ++i) {
                children += '<li>Załączone pliki</li>';
                children += '<li>' + input.files.item(i).name + '<span class="remove-list" onclick="return this.parentNode.remove()">Usuń</span>' + '</li>'
            }
            output.innerHTML = children;
        }
    }
}
</script>

<style>
@import 'datatables.net-dt';
</style>
