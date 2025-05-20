<template>
    <div class="mt-3 overflow-auto" style="width:100%">
        <DataTable class="table table-hover" style="width:100%" :data="data" :options="tableOptions">
            <thead>
            <tr>
                <th v-for="column in columns">{{ column }}</th>
            </tr>
            </thead>
        </DataTable>
    </div>
</template>

<script>

import DataTable from 'datatables.net-vue3';

export default {
    props: ['columns','data'],
    setup() {
        const tableOptions = {
            "language": {
                "search": "Szukaj",
                "lengthMenu": "Pokazuję _MENU_ rekordów na stronę",
                "zeroRecords": "Brak rekordów",
                "thousands": " ",
                "decimal":",",
                "info": "Pokazuję stronę _PAGE_ z _PAGES_",
                "infoEmpty": "Brak rekordów",
                "infoFiltered": "(filtrowane z _MAX_ wpisów)",
                "emptyTable": "Tabela jest pusta",
                "paginate": {
                    "first": "Pierwsza",
                    "last": "Ostatnia",
                    "next": "Następna",
                    "previous": "Poprzednia",
                }
            },
            "aria": {
                "sortAscending": ": naciśnij aby posortować rosnąco",
                "sortDescending": ": naciśnij aby posortować malejąco"
            }
        }
        return {
            tableOptions,
        }
    },
    components: {
        DataTable,
    },
}
</script>
<style>
@import 'bootstrap';
@import 'datatables.net-dt';
@import 'datatables.net-bs5';
</style>
