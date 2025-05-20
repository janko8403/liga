<template>
    <div class="row justify-content-center mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">
                                    #
                                </th>
                                <th scope="col">
                                    Agent
                                </th>
                                <th scope="col">
                                    vs
                                </th>
                                <th scope="col">
                                    Agent
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <template v-for="item in duels" :key="item.id">
                                <tr>
                                    <th scope="row">
                                        {{ item.id }}
                                    </th>
                                    <td>
                                        {{ item.first_contender }}
                                    </td>
                                    <td>
                                        {{ item.second_contender }}
                                    </td>
                                    <td>
                                        {{ item.permissions }}
                                    </td>
                                    <td>
                                        <span class="mr-2">
                                        <router-link :to="{ name: 'duel.edit', params: { id: item.id } }"
                                                     class="mr-2 btn btn-m">
                                            Edycja
                                        </router-link>
                                        </span>
                                        <button @click="deleteDuel(item.id)"
                                                class="btn btn-m">
                                            Usuń
                                        </button>
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
import useDuels from '../../../composables/backend/duels'
import { onMounted } from 'vue';

export default {
    props: {
        edition_id: {
            required: true,
        },
    },
    setup() {
        const { duels, getDuels } = useDuels()
        onMounted(getDuels)

        return {
            duels,
        }
    }
}
</script>
