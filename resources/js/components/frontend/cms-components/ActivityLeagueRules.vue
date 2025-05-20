<template>
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header" :id="section.id">
                <button
                    class="accordion-button"
                    :class="{ collapsed: !show}"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="`#collapse-${section.id}`"
                    aria-expanded="true"
                    :aria-controls="`collapse-${section.id}`"
                >
                    {{ sData('title')}}
                </button>
            </h2>
            <div
                class="accordion-collapse collapse"
                :class="{ show: show }"
                :id="`collapse-${section.id}`"
                :aria-labelledby="`${section.id}`"
            >
                <div class="accordion-body">

                    <div>
                        <p v-html="sData('content')"></p>

                        <p class="pt-4" v-if="sData('regulamin')">
                            <a :href="sData('regulamin')" target="_blank" class="text-decoration-none">
                                <div class="icon-font icon-color_g icon_u icon-font_lg">Regulamin.pdf</div>
                            </a>
                        </p>
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
        function addOLClass() {
            let listItems = document.querySelectorAll('.editor-content > ul');
            for(let i = 0; i < listItems.length; i++) {
                listItems[i].className = 'list';
            }
        }

        function addULClass() {
            let listItems = document.querySelectorAll('.editor-content > ol');
            for(let i = 0; i < listItems.length; i++) {
                listItems[i].className = 'list';
            }
        }
        onMounted(() => addOLClass() );
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
    },
    data() {
        return {
            show: true,
        }
    }
}
</script>
