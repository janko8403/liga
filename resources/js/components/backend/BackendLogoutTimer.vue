<template>
    {{ timerMinutes }} : {{ timerSeconds }}
</template>

<script>
export default {
    data() {
        return {
            timerCount: 900
        }
    },
    computed: {
        timerMinutes() {
            if (this.timerCount < 1) {
                window.location.href = '/backend/logout'
            }
            return parseInt(this.timerCount/60)
        },
        timerSeconds() {
            let tsec = this.timerCount % 60;
            if (tsec < 10) {
                return "0"+tsec;
            }
            return tsec
        }
    },
    watch: {
        timerCount: {
            handler(value) {
                if (value > 0) {
                    setTimeout(() => {
                        this.timerCount--;
                    }, 1000);
                }
            },
            immediate: true
        }

    },
}
</script>
