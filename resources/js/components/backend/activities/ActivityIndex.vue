<template>
    <div class="h3 mt-4 mb-3">Aktywności |<span class="text-muted h3"> Lista</span></div>

    <div class="row mt-3">
        <div class="col-6" v-for="item in activities" :key="item.id">
            <div class="card mb-3">
                <img v-if="item.header" :src="item.header.file_path" class="card-img-top" alt="Header"/>
                <div class="card-body">
                    <h5 class="card-title">{{ item.name }}</h5>
                    <p class="card-text">
                        <small class="text-muted">{{ item.active_from }} - {{ item.active_to }}</small>
                    </p>
                    <router-link :to="{ name: 'activities.edit', params: { id: item.id } }"
                                 class="mr-2 btn btn-m">
                        Edycja
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useActivities from '../../../composables/backend/activities'
import { onMounted } from 'vue';

export default {
    setup() {
        const { activities, getActivities } = useActivities()
        onMounted(getActivities)
        return {
            activities,
        }
    }
}
</script>
