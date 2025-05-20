<template>
    <div class="row justify-content-center mt-5">
        <div class="col-12">
            <div className="mt-2 mb-6 text-sm text-red-600" v-if="errors !== ''">
                {{ errors }}
            </div>
            <form class="row g-3" v-on:submit.prevent="saveDuel">
                <input type="hidden" name="_token" v-bind:value="csrf">
                <div class="col-md-5 col-xs-12">
                    <multiselect v-if="freeMSK[0] && firstNepu!='0'" v-model="firstNepu" :options="freeMSK"
                                 label="msk"
                                 track-by="nepu_msk"
                                 :multiple="false"
                                 selectLabel="Wybierz"
                                 selectedLabel="Wybrano"
                                 deselect-label="Usuń"
                                 placeholder="Wybierz"
                                 :close-on-select="true"
                                 :clear-on-select="false">
                    </multiselect>
                </div>
                <div class="col-md-2 col-xs-12">
                    vs
                </div>
                <div class="col-md-5 col-xs-12">
                    <multiselect v-if="freeMSK[0] && secondNepu!='0'" v-model="secondNepu" :options="freeMSK"
                                 label="msk"
                                 track-by="nepu_msk"
                                 :multiple="false"
                                 selectLabel="Wybierz"
                                 selectedLabel="Wybrano"
                                 deselect-label="Usuń"
                                 placeholder="Wybierz"
                                 :close-on-select="true"
                                 :clear-on-select="false">
                    </multiselect>
                </div>
                <div class="col-md-6 col-xs-12 mt-3">
                    <div class="mb-3">
                        <label class="form-label">Wartość nagrody</label>
                        <input type="text" class="form-control" v-model="duel.award" placeholder="0">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 mt-3">
                    <div class="form-check form-switch">
                        <label class="form-check-label">Status</label>
                        <input class="form-check-input" type="checkbox" id="status" v-model="duel.status">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Uprawnienia</label>
                        <multiselect v-model="duel.permissions" :options="allPermissions"
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
                <div>
                    <label class="form-label">Czas trwania</label>
                    <div class="col-12 mt-3">
                        <label for="active_from" class="form-label">Początek aktywności</label>
                        <datepicker v-model="duel.active_from" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_from"/>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="active_from" class="form-label">Koniec aktywności</label>
                        <datepicker v-model="duel.active_to" locale="pl" cancelText="Anuluj" format="yyyy-MM-dd" selectText="Wybierz" id="active_to"/>
                    </div>
                </div>
                <div class="col-9">
                </div>
                <div class="col-3 justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import {nextTick, onMounted, ref} from 'vue';
import useDuels from "../../../composables/backend/duels";
import AutoSelect from "../elements/AutoSelect";
import multiselect from "vue-multiselect";
import useUsersPermissions from "../../../composables/backend/permissions";
import Datepicker from "@vuepic/vue-datepicker";
import 'vue3-autocomplete/dist/vue3-autocomplete.css'
import {useToast} from "bootstrap-vue-3";

export default {
    props: {
        duelData: {
            required: true,
        }
    },
    components: {
        multiselect,
        Datepicker,
        AutoSelect,
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    setup(props,{emit}) {
        let toast = useToast()
        let showInfo = (info) => {
            if (info) {
                toast.show({ title: info })
            }
            else {
                toast.show({ title: errors })
            }
        }
        const { errors, firstNepu, secondNepu, duel, updateDuel, freeMSK, getDuelFreeMSKUsers, getDuel } = useDuels()
        const { allPermissions, getAllPermissions } = useUsersPermissions()

        onMounted(() => getDuel(props.duelData.id))
        onMounted( () => getDuelFreeMSKUsers(props.duelData.edition_id,props.duelData.first_nepu,props.duelData.second_nepu))
        onMounted(() => getAllPermissions())

        const saveDuel = async () => {
            errors.value = '';
            if (firstNepu.value) {duel.value.first_nepu = firstNepu.value.nepu_msk;}
            if (secondNepu.value) {duel.value.second_nepu = secondNepu.value.nepu_msk;}
            if (duel.value.first_nepu != duel.value.second_nepu) {
                await updateDuel(props.duelData.id)
                await nextTick()
                document.documentElement.querySelector(".modal.fade.show .btn-close").click();
                emit('updateDuel',true);
            }
            else {
                errors.value = 'Wybierz różnych uczestników';
                showInfo(errors)
            }
        }

        return {
            errors,
            duel,
            firstNepu,
            secondNepu,
            freeMSK,
            allPermissions,
            saveDuel
        }
    }
}
</script>
