<template>
    <h1>{{ sData("title") }}</h1>

    <p class="pt-3">
        {{ sData("content") }}
    </p>
</template>

<script>
export default {
    props: {
        section: {
            required: true
        }
    },
    methods: {
        getDataIndex(name) {
            return this.section.data.findIndex(p => p.name === name)
        },
        sData(name) {
            let index = this.getDataIndex(name)
            if (index >= 0) {
                let row = this.section.data[index]
                return (row.value)
            }
        },
        vData(name) {
            let row = JSON.parse(this.section.component.labels);
            return row[name]
        },
    }
}
</script>
