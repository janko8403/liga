<template>
    <b-container :toast="{root: true}" fluid="sm" style="z-index: 10" position="position-fixed"></b-container>
    <router-view />
</template>

<script>
    export default {
        mounted() {
            console.log('Backend component mounted.')
        }
    }
</script>
