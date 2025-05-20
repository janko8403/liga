<template>
    <div class="h3 mt-5 mb-3">
        <span class="text-muted h3 ml-1"></span>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-3 col-xs-12">
            <DuelMainEditionSettings></DuelMainEditionSettings>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <nav class="navbar navbar-light bg-light justify-content-between p-3">
                        <a class="navbar-brand">Kategorie pojedynków</a>
                        <button class="btn btn-secondary my-2 my-sm-0" @click='addDuelEdition' type="submit">Nowa kategoria pojedynku</button>
                    </nav>
                    <div class="">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">
                                    #
                                </th>
                                <th scope="col">
                                    Nazwa
                                </th>
                                <th scope="col">
                                    Kategoria
                                </th>
                                <th scope="col">
                                    Czas trwania
                                </th>
                                <th>
                                    Status
                                </th>
                                <th scope="col"></th>
                            </tr>
                            </thead>

                            <tbody>
                            <template v-for="item in duelsEditions" :key="item.id">
                                <tr>
                                    <td scope="row">
                                        {{ item.id }}
                                    </td>
                                    <td>
                                        {{ item.name }}
                                    </td>
                                    <td>
                                        {{ item.category }}
                                    </td>
                                    <td>
                                        {{ item.active_from }} - {{ item.active_to }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success p-2 mt-1" v-if="item.status">
                                            Aktywna
                                        </span>
                                        <span class="badge bg-secondary p-2 mt-1" v-else>
                                            Nieaktywna
                                        </span>
                                    </td>
                                    <td>
                                        <span class="mr-2">
                                        <router-link :to="{ name: 'duels.edit', params: { edition_id: item.id } }"
                                                     class="mr-2 btn btn-light">
                                            Szczegóły
                                        </router-link>
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
</template>

<script>
import {nextTick, onMounted} from 'vue';
import useDuelsEditions from "../../../composables/backend/duels-editions";
import DuelMainEditionSettings from "./DuelMainEditionSettings";

export default {
    components: {DuelMainEditionSettings},
    setup() {
        const { duelsEditions, storeDuelEdition, getDuelEditions } = useDuelsEditions()
        onMounted(getDuelEditions)

        const addDuelEdition = async () => {
            await storeDuelEdition([]);
            await nextTick();
            await getDuelEditions()
        }

        return {
            duelsEditions,
            addDuelEdition,
        }
    },
}
</script>
