<template>
    <form class="row g-3" v-on:submit.prevent="saveNotify(notify.id)">
        <input type="hidden" name="_token" v-bind:value="csrf">
        <div class="col-12">
            <div class="input-group mb-3">
                <span class="input-group-text">Tytuł powiadomienia</span>
                <input type="text" class="form-control" v-model="notify.title">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-3">
                <span class="input-group-text">Treść powiadomienia</span>
                <textarea class="form-control" v-model="notify.content" aria-label="Treść powiadomienia"></textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group mb-3">
                <span class="input-group-text">CTA URL</span>
                <input type="text" class="form-control" v-model="notify.cta">
            </div>
        </div>
        <div class="col-9">
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" v-model="notify.status">
                <label class="form-check-label" for="exampleCheck1">Powiadomienie aktywne</label>
            </div>
        </div>
        <div class="col-3">
            <div class="mb-3 form-check">
                <label for="color" class="form-label">Kolor tła</label>
                <input type="color" class="form-control form-control-color" v-model="notify.bg_color" title="Wybierz kolor">
            </div>
        </div>
        <div>
            <label class="form-label">Czas trwania</label>
            <div class="col-12 mt-3">
                <label for="active_from" class="form-label">Wyświetlanie powiadomienia od</label>
                <datepicker v-model="notify.active_from" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_from"/>
            </div>
            <div class="col-12 mt-3">
                <label for="active_from" class="form-label">Zakończenie wyświetlania powiadomienia</label>
                <datepicker v-model="notify.active_to" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_to"/>
            </div>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">Wyświetlane dla grup uprawnień</label>
                <multiselect v-model="notify.permissions" :options="allPermissions"
                             label="name"
                             track-by="id"
                             :multiple="true"
                             selectLabel="Wybierz"
                             selectedLabel="Wybrano"
                             deselect-label="Usuń"
                             placeholder="Wybierz"
                             :close-on-select="false"
                             :clear-on-select="false">
                </multiselect>
            </div>
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-primary">Zapisz</button>
        </div>
    </form>
</template>

<script>
import useNotifies from '../../../composables/backend/notify'
import {nextTick, onMounted} from 'vue';
import Datepicker from "@vuepic/vue-datepicker";
import useUsersPermissions from "../../../composables/backend/permissions";
import multiselect from "vue-multiselect";

export default {
    components: {
        Datepicker,
        multiselect,
    },
    props: {
        notify_id: {
            required: true,
        }
    },
    emits: [
        'refresh_notifies',
    ],
    setup(props,{emit}) {
        const { notify, getNotify, updateNotify } = useNotifies()
        const { allPermissions, getAllPermissions } = useUsersPermissions()
        onMounted(() => getAllPermissions())

        onMounted(() => getNotify(props.notify_id))

        const saveNotify = async () => {
            await updateNotify(props.notify_id);
            await nextTick();
            await getNotify(props.notify_id);
            await emit('refresh_notifies',true);
        }

        return {
            saveNotify,
            allPermissions,
            notify,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
