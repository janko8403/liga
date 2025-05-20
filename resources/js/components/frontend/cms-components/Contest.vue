<template>
    <div class="row">
        <div class="col">
            <div class="card-results">
                <h2 class="pb-4">Zasady aktywności</h2>
                <div class="row">
                    <div class="editor-content" v-html="contest.description_before"></div>
                    <div class="mt-4 editor-content" v-html="contest.description_after"></div>
                </div>
                    <template v-for="item in files" :key="item.id">
                        <div class="row mt-5">
                        <a class="text-decoration-none" :href="item.file_path">
                            <div class="icon-font icon-color_g icon_u icon-font_lg">
                                {{ item.org_name }}
                            </div>
                        </a>
                        </div>
                    </template>
                <div class="row mt-5">
                    <a class="text-decoration-none" :href="'/api/frontend/data-export/4/'+contest_id">
                        <div class="icon-font icon-color_g icon_u icon-font_lg">
                            Ranking
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {nextTick, onMounted} from "vue";
import useCMS from "../../../composables/frontend/cms";
import useFiles from "../../../composables/frontend/files";

export default {
    components: {
    },
    props: {
        contest_id: {
            required: true
        }
    },
    setup(props) {
        const { contest, getContest } = useCMS()
        const { files, getFiles } = useFiles()
        onMounted(() => getFiles(props.contest_id,'contest'))
        onMounted(() => getContest(props.contest_id))

        const addULClass = async () => {
            await nextTick();
            let listItems = document.querySelectorAll('.editor-content ul');
            for(let i = 0; i < listItems.length; i++) {
                listItems[i].className = 'list-number';
            }
        }
        onMounted(() => addULClass() );

        const addOLClass = async () => {
            await nextTick();
            let listItems = document.querySelectorAll('.editor-content ol');
            for(let i = 0; i < listItems.length; i++) {
                listItems[i].className = 'list';
            }
        }
        onMounted(() => addOLClass() );
        return {
            contest,
            files,
        }
    },
}
</script>
