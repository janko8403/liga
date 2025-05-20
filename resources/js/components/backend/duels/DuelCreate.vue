<template>
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
                        {{ item.first_agent }}
                    </td>
                    <td>
                        {{ item.second_agent }}
                    </td>
                    <td>
                        <router-link :to="{ name: 'duels.edit', params: { id: item.id } }"
                                     class="mr-2 btn btn-primary">
                            Edycja
                        </router-link>
                        <button @click="destroyDuel(item.id)"
                                class="btn btn-danger">
                            Usuń pojedynek
                        </button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
import useDuels from '../../../composables/backend/duels'
import { onMounted } from 'vue';

export default {
    setup() {
        const { duels, getDuels } = useDuels()

        onMounted(getDuels)

        return {
            duels,
        }
    }
}
</script>
