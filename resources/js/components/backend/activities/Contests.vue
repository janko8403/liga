<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
        <a class="navbar-brand" href="#"></a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button class="btn btn-secondary me-2" @click='newContest'>Nowy konkurs</button>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row mt-3">
        <div class="col-3" v-for="item in contests" :key="item.id">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ item.name }}</h5>
                    <p class="card-text">
                        <small class="text-muted">{{ item.active_from }} - {{ item.active_to }}</small>
                    </p>
                    <router-link :to="{ name: 'activities.contest', params: { contest_id: item.id } }" class="mr-2 btn btn-m">
                        Szczegóły
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useContests from '../../../composables/backend/contest'
import {nextTick, onMounted} from 'vue';

export default {
    setup() {
        const { contests, getContests, storeContest } = useContests()
        onMounted(() => getContests())

        const newContest = async () => {
            await storeContest();
            await nextTick();
            await getContests();
        }
        return {
            contests,
            newContest,
        }
    }
}
</script>
