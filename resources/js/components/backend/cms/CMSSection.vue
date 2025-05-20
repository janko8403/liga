<template>
<div class="p-3 mt-2 col-xs-12" v-bind:class="getCols">
    <div class="card p-3">
        <nav class="navbar navbar-light bg-light justify-content-between p-2">
            <a class="navbar-brand">{{ section.component.name }}</a>
            <form v-on:submit.prevent="">
                <button class="btn btn-outline-primary p-0 ms-2" title="Do góry" v-if="section.order_id>1" @click="reorderSection(section.id,1)">
                    <i class="fa fa-2xs fa-solid fa-chevron-up"></i>
                </button>
                <button class="btn btn-outline-primary p-0 ms-2" title="Do góry" @click="reorderSection(section.id,2)">
                    <i class="fa fa-2xs fa-solid fa-chevron-down"></i>
                </button>
                <button class="btn btn-outline-danger p-0 ms-2" title="Usuń sekcję" v-if="edit_component === section.id" @click="deleteSection(section.id)">
                    <i class="fa fa-2xs fa-solid fa-trash"></i>
                </button>
                <button class="btn btn-outline-primary p-0 ms-1" title="Edycja" v-if="edit_component !== section.id" @click="editComponentData(section.id)">
                    <i class="fa fa-solid fa-edit fa-2xs"></i>
                </button>
                <button class="btn btn-outline-primary p-0 ms-1"  title="Anuluj" v-if="edit_component === section.id" @click="cancelEditComponentData(section.id)">
                    <i class="fa fa-solid fa-xmark fa-2xs"></i>
                </button>
                <!--button class="btn btn-outline-secondary p-0 ml-2" title="Wyświetlanie sekcji" @click="toggleSectionVisibility"><i class="fa fa-2xs fa-solid fa-lightbulb"></i></button>-->
            </form>
        </nav>
        <div class="p-4">
            <template id="view" v-if="edit_component !== section.id"  v-for="(value,name) in section.component.parameters">
                <template v-if='value === "string"'>
                    <div class="row">
                        <div class="col-12">
                            <h3>{{ sData(name) }}</h3>
                        </div>
                    </div>
                </template>
                <template v-if='value === "richtext" || value === "richtext-bordered"'>
                    <div class="row" >
                        <div class="col-12">
                            <div v-html="sData(name)"></div>
                        </div>
                    </div>
                </template>
                <template v-if='value === "image"'>
                    <div class="row">
                        <div class="col-12">
                            <img :src="sData(name)" alt="Obraz">
                        </div>
                    </div>
                </template>
                <template v-if='value === "file"'>
                    <div class="row">
                        <div class="col-12">
                            <a target="_blank" :href="sData(name)">Załączony plik</a>
                        </div>
                    </div>
                </template>
            </template>
            <form ref="form" v-on:submit.prevent="saveSectionDetails(section.id)">
            <input type="hidden" name="component_id" :value="section.component_id">
            <input type="hidden" name="section_id=" :value="section.id">
            <template id="edit" v-if="edit_component === section.id" v-for="(value,name,index) in section.component.parameters">
            <div>
                <template v-if='value === "string"'>
                    <div class="row mb-4">
                        <div>{{ vData(name) }}</div>
                        <input type="text" class="form-control" :name="name" :value="sData(name)">
                    </div>
                </template>
                <template v-if='value === "text"'>
                    <div class="row mb-2">
                        <div>{{ vData(name) }}</div>
                        <textarea class="form-control rich" :name="name">{{ sData(name) }}</textarea>
                    </div>
                </template>
                <template v-if='value === "richtext" || value === "richtext-bordered"'>
                    <div class="row mb-2">
                        <div>{{ vData(name) }}</div>
                        <div class="col-12 mt-3" style="margin-bottom:80px">
                            <textarea :name="name" class="quill-text" style="display:none" :id="index"></textarea>
                            <Editor contentType="html" :content='sData(name)' :id='"quill-"+index' :toolbar="customToolbar" theme="snow"></Editor>
                        </div>
                    </div>
                </template>
                <template v-if='value === "image" || value === "file"'>
                        <div class="row">
                            <div>
                                <div>{{ vData(name) }}</div>
                                <img v-if="sData(name) && value === 'image'"  :src="sData(name)" alt="Obraz" style="max-height:150px">
                                <p v-if="value === 'file'">Załącznik {{sData(name)}}</p>
                            </div>
                            <input type="file" :id="name" v-on:change="submitFile($event,name)" style="display:none"/>
                            <input type="hidden" :name="name" :id="name+'-image'" :value="sData(name)">
                            <div class="col-2">
                                <div class="btn btn-light mt-1" v-on:click="selectFile(name)">Zmień</div>
                            </div>
                        </div>
                </template>
            </div>
            </template>

            <div class="row" v-if="edit_component === section.id">
                <div class="col-md-6 col-xs-12 ms-auto text-end">
                    <div class="btn btn-outline-primary p-0 ms-2" title="Zmniejsz sekcję" v-if="columns>3" @click="changeSectionColumns(1)">
                        <i class="fa fa-2xs fa-solid fa-chevron-left"></i>
                    </div>
                    <div class="btn btn-outline-primary p-0 ms-2" title="Zwiększ sekcję" v-if="columns<12" @click="changeSectionColumns(2)">
                        <i class="fa fa-2xs fa-solid fa-chevron-right"></i>
                    </div>
                    <input type="hidden" class="form-control" name="columns" :value="columns">
                </div>
                <div class="col-md-6 col-xs-12" style="text-align:right">
                    <button type="submit"
                            className="btn btn-primary me-3">
                        Zapisz
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import {nextTick, onMounted} from "vue";
import useCMSSectionData from "../../../composables/backend/cms-section-data";
import { QuillEditor as Editor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {useToast} from "bootstrap-vue-3";

import axios from "axios";

export default {
    props: {
        section: {
            required: true,
        },
    },
    components: {
        Editor
    },
    emits: [
        'refresh_sections',
        'edit_section',
    ],
    setup(props,{emit}) {
        const {sectionData, moveSection, destroySection, getSectionData } = useCMSSectionData();
        onMounted(() => getSectionData(props.section.id, props.section.component_id));

        function refreshView() {
            emit('refresh_sections',props.section.menu_id);
        }

        const reorderSection = async (id,direction) =>  {
            await moveSection(id,direction);
            await nextTick();
            await refreshView();
        }
        const deleteSection = async (edited_component) =>  {
            await destroySection(edited_component);
            await nextTick();
            await refreshView();
        }

        const submitFile = async(event,name) => {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append('file-upload', file);
            formData.append('activity_id', props.section.id)
            formData.append('type', 'cms-file')

            const fileName =  await axios.post('/api/backend/upload-file',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(response => response.data);
            if (fileName) {
                document.getElementById(name+"-image").value=fileName;
            }
        }

        const selectFile = (name) => {
            document.getElementById(name).click()
        }

        return {
            sectionData,
            reorderSection,
            refreshView,
            deleteSection,
            submitFile,
            selectFile,
        }
    },
    data() {
        return {
            columns: this.section.columns,
            edit_component: 0,
            customToolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['clean']],
        }
    },
    computed: {
        getCols() {
            return "col-md-" + this.columns;
        }
    },
    methods: {
        getDataIndex(name) {
            return this.sectionData.findIndex(p => p.name === name)
        },
        sData(name) {
            let index = this.getDataIndex(name)
            if (index >= 0) {
                let row = this.sectionData[index]
                return (row.value)
            }
        },
        sIndex(name) {
            let index = this.getDataIndex(name)
            if (index >= 0) {
                let row = this.sectionData[index]
                return (row.id)
            }
        },
        vData(name) {
            let row = JSON.parse(this.section.component.labels);
            return row[name]
        },
        saveSectionDetails(id) {
            let editors = document.getElementsByClassName("quill-text");
            for (let i = 0; i < editors.length; i++) {
                let cEditor = document.querySelector('#quill-'+editors[i].id+' .ql-editor');
                document.getElementById(editors[i].id).innerHTML = cEditor.innerHTML;
            }
            const formData = new FormData(this.$refs['form']);
            const data = {};
            for (let [key, val] of formData.entries()) {
                Object.assign(data, { [key]: val })
            }
            axios.post(`/api/backend/cms/sections/data/${id}`, data).finally(response => {
                this.edit_component = 0;
                this.refreshView();
            });
        },
        editComponentData(id) {
            this.edit_component = 0;
            this.edit_component = id;
        },
        cancelEditComponentData() {
            this.edit_component = 0;
        },
        changeSectionColumns(direction) {
            switch(direction) {
                case 1:
                    this.columns>3?this.columns--:'';
                    break;
                case 2:
                    this.columns<12?this.columns++:'';
                    break;
            }
        }
    }
}
</script>
