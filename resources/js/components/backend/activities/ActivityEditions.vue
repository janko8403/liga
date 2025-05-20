<template>
    <div class="row justify-content-center mt-3">
        <table class="table">
            <thead>
            <tr>
                <th>Edycja</th>
                <th>Data rozpoczęcia</th>
                <th>Data zakończenia</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="item in activity.editions" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.active_from }}</td>
                    <td>{{ item.active_to }}</td>
                    <td>
                        <span class="badge bg-success p-2 mt-1" v-if="item.status">
                            Aktywna
                        </span>
                        <span class="badge bg-secondary p-2 mt-1" v-else>
                            Nieaktywna
                        </span>
                    </td>
                    <td>
                        <router-link :to="{ name: 'activities.editEdition', params: { id: item.id, activity_id: activity.id } }"
                                     class="mr-2 btn btn-m">
                            Szczegóły
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default {
    props: {
        activity: {
            required: true,
        },
    },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
