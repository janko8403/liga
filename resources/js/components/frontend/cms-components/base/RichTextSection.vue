<template>
    <div class="editor-content" v-html="sData('content')"></div>
</template>

<script>
import {onMounted} from "vue";

export default {
    props: {
        section: {
            required: true
        }
    },
    setup() {
        function addULClass() {
            let listItems = document.querySelectorAll('.editor-content > ul');
            for(let i = 0; i < listItems.length; i++) {
                listItems[i].className = 'list-number';
            }
        }
        onMounted(() => addULClass() );

        function addOLClass() {
            let listItems = document.querySelectorAll('.editor-content > ol');
            for(let i = 0; i < listItems.length; i++) {
                listItems[i].className = 'list';
            }
        }
        onMounted(() => addOLClass() );

        return {

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
