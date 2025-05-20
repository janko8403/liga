<template>
    <div class="row pt-5 pb-5">
        <div class="col-6">
            <img class="img-fluid" :src="sData('image')" alt="Obraz">
        </div>
        <div class="col-6 d-flex align-items-top">
            <p v-html="sData('content')"></p>
        </div>
    </div>
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
