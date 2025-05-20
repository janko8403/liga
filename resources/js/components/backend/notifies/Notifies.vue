<template>
    <div class="row">
        <div class="col-md-9 col-xs-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="h3 mt-3 mb-3">Powiadomienia systemowe</div>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <button class="btn btn-secondary me-2" @click='newNotify'>Nowe powiadomienie</button>
                                </li>
                            </ul>
                        </div>
                    </nav>

                    <dataset
                        v-slot="{ ds }"
                        :ds-data="notifies"
                        :ds-sortby="sortBy"
                        :ds-sort-as="{ title: 'Tytuł' }"
                        :ds-search-in="['title', 'content']"
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
                                            <th scope="col">#</th>
                                            <th v-for="(th, index) in cols" :key="th.field" :class="['sort', th.sort]" @click="click($event, index)">
                                                <span >{{ th.name }}</span> <i class="gg-select float-right" style="float:right"></i>
                                            </th>
                                        </tr>
                                        </thead>
                                        <dataset-item tag="tbody">
                                            <template #default="{ row, rowIndex }">
                                                <tr>
                                                    <th scope="row" class="pt-4">{{ rowIndex + 1 }}</th>
                                                    <td class="pt-4">
                                                        {{ row.title }}
                                                    </td>
                                                    <td class="pt-4">
                                                        <span class="badge bg-success p-2 mt-1" v-if="row.status">
                                                            Aktywna
                                                        </span>
                                                        <span class="badge bg-secondary p-2 mt-1" v-else>
                                                            Nieaktywna
                                                        </span>
                                                    </td>
                                                    <td class="pt-4">
                                                        {{ row.active_from }}
                                                    </td>
                                                    <td class="pt-4">
                                                        {{ row.active_to }}
                                                    </td>
                                                    <td>
                                                        <span><i class="fa fa-solid fa-edit pointer" type="button" data-bs-toggle="modal" data-bs-target="#notifyModal" title="Pokaż szczegóły powiadomienia" @click='editNotify(row.id)'></i></span>
                                                        <span class="pr-2"><i class="fa fa-trash pointer" @click="deleteNotify(row.id)"></i></span>
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
            </div>
         </div>
         <div class="col-3">
             <div class="card mb-3">
                 <div class="card-body">
                    <div class="h3 mt-3 mb-3">Ustawienia formularza</div>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
                        <a class="navbar-brand" href="#"></a>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        </div>
                    </nav>
                    <div>
                        <settings></settings>
                     </div>
                 </div>
             </div>
         </div>
     </div>
    <div class="modal modal-lg fade" id="notifyModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
        <div class="modal-dialog" bs-modal-width="800px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notifyModalLabel">Powiadomienie systemowe</h5>
                    <button type="button" ref="modalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                </div>
                <div class="modal-body">
                    <Notify v-if="notify.id>0" :notify_id="notify.id" @refresh_notifies="refreshNotifies" :key="cKey"></Notify>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useNotifies from '../../../composables/backend/notify'
import {nextTick, onMounted, ref} from 'vue';
import Notify from "./Notify";
import Settings from "./Settings";
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
        Settings,
        Notify,
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
                showingEntries: 'wpisy',
            },
        }
    },
    setup() {
        const { notify, notifies, getNotify, destroyNotify, getNotifies, storeNotify } = useNotifies()
        onMounted(() => getNotifies())

        const modalClose = ref();
        const cKey = ref(0);

        const reRender = () => {
            cKey.value += 1;
        }

        const newNotify = async () => {
            await storeNotify();
            await nextTick();
            await getNotifies();
        }

        const deleteNotify = async (id) => {
            await destroyNotify(id);
            await nextTick();
            await getNotifies()
        }

        const editNotify = async (id) => {
            await getNotify(id)
            await nextTick();
            await reRender();
        }

        const refreshNotifies = async() => {
            await getNotifies()
            await nextTick();
            document.documentElement.querySelector(".modal.fade.show .btn-close").click();
        }

        return {
            notify,
            notifies,
            editNotify,
            refreshNotifies,
            deleteNotify,
            cKey,
            newNotify,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            cols: [
                {
                    name: 'Tytuł',
                    field: 'title',
                    sort: '',
                },
                {
                    name: 'Status',
                    field: 'status',
                    sort: ''
                },
                {
                    name: 'Aktywne od',
                    field: 'active_from',
                    sort: ''
                },
                {
                    name: 'do',
                    field: 'active_to',
                    sort: ''
                },
                {
                    name: '',
                    sort: false,
                }
            ],
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
