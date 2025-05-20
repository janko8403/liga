<template>
    <div class="h3 mt-3 mb-3">Agenci |<span class="text-muted h3"> Lista</span></div>
    <div clas="row">
        <div class="col-12">
            <div class="justify-content-end">
                <a href="/api/backend/users-export" class="btn btn-secondary">Eksport XLS</a>
            </div>
        </div>
    </div>
    <div>
        <dataset
            v-slot="{ ds }"
            :ds-data="users"
            :ds-sortby="sortBy"
            :ds-sort-as="{ name: 'name' }"
            :ds-search-in="['name', 'email', 'dsk', 'njs','lastname','position']"
        >
            <div class="row" :data-page-count="ds.dsPagecount">
                <div class="col-md-2 mt-4 mb-md-0">
                    <dataset-search ds-search-placeholder="Szukaj..." />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table d-md-table">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th v-for="(th, index) in cols" :key="th.field" :class="['sort', th.sort]" @click="click($event, index)">
                                    <span >{{ th.name }}</span> <i class="gg-select float-right" style="float:right"></i>
                                </th>
                            </tr>
                            </thead>
                            <dataset-item tag="tbody">
                                <template #default="{ row, rowIndex }">
                                    <tr>
                                        <th scope="row">{{ rowIndex + 1 }}</th>
                                        <td>{{ row.name }}</td>
                                        <td>{{ row.lastname }}</td>
                                        <td>{{ row.email }}</td>
                                        <td>{{ row.njs }}</td>
                                        <td>{{ row.nepu }}</td>
                                        <td>{{ row.position }}</td>
                                        <td>
                                            <span v-if="row.is_validated === 1">
                                                <span class="badge text-bg-success p-2">Tak</span>
                                            </span>
                                            <span v-if="row.is_validated === 0">
                                                <span class="badge text-bg-warning p-2">Nie</span>
                                            </span>
                                            <span v-if="row.is_validated === 2">
                                                <span class="badge text-bg-info">Wysłano email</span>
                                            </span>
                                        </td>
                                        <td>
                                            <span v-if="row.photo">Tak</span>
                                            <span v-else>Nie</span>
                                        </td>
                                        <td>
                                            <span v-if="row.new_photo">
                                                <span class="badge text-bg-warning">Tak</span>
                                            </span>
                                            <span v-else>Nie</span>
                                        </td>
                                        <td>
                                            <router-link :to="{ name: 'users.edit', params: { id: row.id } }"
                                                         class="mr-2 btn btn-m">
                                                Karta Agenta
                                            </router-link>
                                        </td>
                                    </tr>
                                </template>
                            </dataset-item>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-md-row flex-column justify-content-between align-items-center">
                <dataset-info class="mb-2 mb-md-0" />
                <dataset-pager />
            </div>
        </dataset>
    </div>
</template>

<script>

import useUsers from '../../../composables/backend/users'
import { onMounted } from 'vue';
import {
    Dataset,
    DatasetInfo,
    DatasetItem,
    DatasetPager,
    DatasetSearch,
    DatasetShow
} from 'vue-dataset'

export default {
    components: {
        DatasetInfo,
        DatasetItem,
        Dataset,
        DatasetPager,
        DatasetSearch,
        DatasetShow,
    },
    extends: Dataset,
    data() {
        return {
            datasetI18n: {
                show: 'Pokaż',
                entries: 'wpisów',
                previous: 'Poprzedni',
                next: 'Następny',
                showing: 'Pokazuję',
                showingTo: 'do',
                showingOf: 'z',
                showingEntries: 'wpisy'
            },
        }
    },
    setup() {
        const { users, getUsers } = useUsers()
        onMounted(getUsers)
        return {
            users,
            cols: [
                {
                    name: 'Imię',
                    field: 'name',
                    sort: ''
                },
                {
                    name: 'Nazwisko',
                    field: 'lastname',
                    sort: ''
                },
                {
                    name: 'Email',
                    field: 'email',
                    sort: ''
                },
                {
                    name: 'NJS',
                    field: 'njs_msk',
                    sort: ''
                },
                {
                    name: 'NEPU',
                    field: 'nepu_msk',
                    sort: ''
                },
                {
                    name: 'Stanowisko',
                    field: 'position',
                    sort: ''
                },
                {
                    name: 'Weryfikacja',
                    field: 'is_validated',
                    sort: ''
                },
                {
                    name: 'Zdjęcie',
                    field: 'photo',
                    sort: ''
                },
                {
                    name: 'Nowe zdjęcie',
                    field: 'new_photo',
                    sort: ''
                },
                {
                    name: '',
                    sort: false,
                }
            ]
        }
    },
    computed: {
        sortBy() {
            return this.cols.reduce((acc, o) => {
                if (o.sort) {
                    o.sort === 'asc' ? acc.push(o.field) : acc.push('-' + o.field)
                }

                return acc
            }, [])
        }
    },
    methods: {
        click(event, i) {
            let toset
            const sortEl = this.cols[i]

            if (!event.shiftKey) {
                this.cols.forEach((o) => {
                    if (o.field !== sortEl.field) {
                        o.sort = ''
                    }
                })
            }
            if (!sortEl.sort) {
                toset = 'asc'
            }
            if (sortEl.sort === 'desc') {
                toset = event.shiftKey ? '' : 'asc'
            }
            if (sortEl.sort === 'asc') {
                toset = 'desc'
            }
            sortEl.sort = toset
        },
    }
}
</script>



