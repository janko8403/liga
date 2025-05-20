<template>
    <p class="pt-3" style="width:100%;text-align: center">
        <img :src="sData('image')" alt="PZU">
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
