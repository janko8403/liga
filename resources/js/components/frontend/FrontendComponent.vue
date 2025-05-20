<template>
    <router-view />
    <Preloader />
</template>

<script>
import Preloader from '../../components/frontend/subcomponents/Preloader.vue';
    export default {
        components: {
            Preloader
        },
        data() {
            return {}
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

