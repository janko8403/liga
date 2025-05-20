<template>
    {{ timerMinutes }} : {{ timerSeconds }}
</template>

<script>
export default {
    props: {
        timer_count: {}
    },
    computed: {
        timerMinutes() {
            if (this.timerCount < 1) {
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
    data() {
        return {
            timerCount:this.timer_count,
        };
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
