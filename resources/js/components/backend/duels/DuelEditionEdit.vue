<template>
    <div class="h3 mt-5 mb-3">
        <span class="text-muted h3 ml-1"></span>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-3 col-xs-12">
            <DuelEditionSettings :edition_id="edition_id"></DuelEditionSettings>
        </div>
        <div class="col-9">
            <div class="card mb-3">
                <div class="card-body">
                    <ActivityDataImport :show_export="true" :type="activity_type" :show_import="true" :edition_id="edition_id" :activity_id="0"></ActivityDataImport>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <nav class="navbar navbar-light bg-light justify-content-between p-3">
                        <a class="navbar-brand">Pojedynki</a>
                        <span class="my-2 my-sm-0">Dostępne drużyny {{ duelsCount }}</span>
                        <button class="btn btn-secondary my-2 my-sm-0" @click='addDuel' type="submit">Nowy pojedynek</button>
                    </nav>
                    <div class="">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">
                                    #
                                </th>
                                <th scope="col">

                                </th>
                                <th scope="col">

                                </th>
                                <th scope="col">

                                </th>
                                <th scope="col">
                                    Status
                                </th>
                                <th scope="col">
                                    Czas trwania
                                </th>
                                <th scope="col">

                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <template v-for="item in duels" :key="item.id">
                                <tr>
                                    <td scope="row">
                                        {{ item.id }}
                                    </td>
                                    <td>
                                        <span v-if="item.first_contender">{{ item.first_contender.msk }} ({{item.first_contender.nepu_msk}})</span>
                                        <span v-else>Brak</span>
                                    </td>
                                    <td>vs</td>
                                    <td>
                                        <span v-if="item.second_contender">{{ item.second_contender.msk }}({{item.second_contender.nepu_msk}})</span>
                                        <span v-else>Brak</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success p-2 mt-1" v-if="item.status">
                                            Aktywny
                                        </span>
                                        <span class="badge bg-secondary p-2 mt-1" v-else>
                                            Nieaktywny
                                        </span>
                                    </td>
                                    <td>
                                        {{ item.active_from }} - {{ item.active_to }}
                                    </td>
                                    <td>
                                        <span class="mr-2">
                                            <i class="fa fa-solid fa-edit pointer" type="button" data-bs-toggle="modal" data-bs-target="#duelModal" title="Pokaż szczegóły pojedynku" @click='editEditionDuel(item.id)'></i>
                                        </span>
                                        <span>
                                            <i class="fa fa-solid fa-trash pointer" title="Usuń pojedynek" @click='deleteEditionDuel(item.id)'></i>
                                        </span>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-lg fade" id="duelModal" tabindex="-1" aria-labelledby="duelModalLabel" aria-hidden="true">
        <div class="modal-dialog" bs-modal-width="800px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duelModalLabel">Pojedynek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                </div>
                <div class="modal-body">
                    <DuelEdit v-if="duel.id > 0" :duelData="duel" @updateDuel="reRender" :key="cKey"></DuelEdit>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {nextTick, onMounted, ref} from 'vue';
import useDuels from "../../../composables/backend/duels";
import DuelEditionSettings from "./DuelEditionSettings";
import DuelEdit from "./DuelEdit";
import ActivityDataImport from "../activities/ActivityDataImport";

export default {
    components: {ActivityDataImport, DuelEditionSettings, DuelEdit },
    props: {
        edition_id: {
            required: true,
        },
    },
    setup(props) {
        const { duel, duels, duelsCount, getDuel, storeDuel, getDuels, destroyDuel } = useDuels()
        onMounted(() => getDuels(props.edition_id))

        let activity_type = 'duelEdition';
        const cKey = ref(0);

        const reRender = () => {
            getDuels(props.edition_id)
            cKey.value += 1;
        }
        const deleteEditionDuel = async (id) => {
            await destroyDuel(id);
            await nextTick();
            await getDuels(props.edition_id)
        }

        const addDuel = async () => {
            await storeDuel([props.edition_id]);
            await nextTick();
            await getDuels(props.edition_id)

        }
        const editEditionDuel = async (id) => {
            await getDuel(id)
            await nextTick();
            await reRender();
        }

        return {
            cKey,
            duel,
            duels,
            duelsCount,
            reRender,
            activity_type,
            editEditionDuel,
            deleteEditionDuel,
            addDuel,
        }
    },
}
</script>
