<template>
    <div v-if="show" class="preloader-container">
        <div class="preloader">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            show: true
        }
    },
    mounted() {
        this.showPreloader()
    },
    methods: {
        showPreloader() {
            setTimeout(() => {
                this.show = false
            }, 3000)
        }
    }
}
</script>