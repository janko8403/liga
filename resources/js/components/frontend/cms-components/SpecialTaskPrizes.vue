<template>
    <div class="row">
        <div class="col">
            <div class="card-results">
                <h2 class="pb-4" v-html="sData('title')"></h2>

                <div class="row">
                    <div class="col-md-12 col-lg-4 editor-content" v-html="sData('first-content')">

                    </div>
                    <div class="col-md-12 col-lg-4">
                        <img class="img-fluid" :src="sData('image1')" alt="Nagrody">
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <img class="img-fluid" :src="sData('image2')" alt="Nagrody">
                    </div>
                </div>
                <div class="row pt-5">
                    <div class="col-md-12 editor-content" v-html="sData('second-content')">
                    </div>
                </div>

                <div class="row pt-5">
                    <div class="col-md-12 col-lg-4">
                        <img class="img-fluid" :src="sData('image3')" alt="Nagrody">
                        <p class="text-center pt-3" v-html="sData('img-title1')"></p>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <img class="img-fluid" :src="sData('image4')" alt="Nagrody">
                        <p class="text-center pt-3" v-html="sData('img-title2')"></p>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <img class="img-fluid" :src="sData('image5')" alt="Nagrody">
                        <p class="text-center pt-3" v-html="sData('img-title3')"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import {onMounted} from "vue";

export default {
    components: {
    },
    props: {
        section: {
            required: true
        }
    },
    setup() {
        function addULClass() {
            let listItems = document.querySelectorAll('.editor-content > ul');
            for(let i = 0; i < listItems.length; i++) {
                listItems[i].className = 'list';
            }
        }
        onMounted(() => addULClass() );

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
};
</script>
