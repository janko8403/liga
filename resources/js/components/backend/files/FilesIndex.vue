<template>
    <div class="row">
        <div class="col-6">Załączone pliki</div>
        <div class="col-6 ">
            <div class="d-right">
                <div style="visibility:hidden">
                    <input type="file" id="fileControllerSelect" ref="file" v-on:change="submitFile($event)"/>
                </div>
                <button class="btn btn-secondary" v-on:click="selectFile()">Dodaj</button>
            </div>
        </div>
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">
                        Nazwa pliku
                    </th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody>
                <template v-for="item in files" :key="item.id">
                    <tr>
                        <td>
                            <a :href="item.file_path">{{ item.org_name }}</a>
                        </td>
                        <td>
                            <button @click="removeFile(item.id)"
                                    class="btn btn-m">
                                Usuń
                            </button>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import useFiles from '../../../composables/backend/files'
import {nextTick, onMounted} from 'vue';
import {useToast} from "bootstrap-vue-3";

export default {
    props: ['activity_id','file_type'],
    setup(props) {
        const { errors, files, deleteFile, getFiles } = useFiles()
        onMounted(() => getFiles(props.activity_id,props.file_type))

        let toast = useToast()
        let showInfo = (info) => {
            toast.show({title: info })
        }

        const submitFile = (event) => {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append('file-upload', file);
            formData.append('activity_id', props.activity_id);
            formData.append('type', props.file_type);

            let response = axios.post('/api/backend/upload-file',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(function(){
                showInfo("Zapisano plik");
                refreshFiles();
            })
                .catch(function(){
                    showInfo("Nie zapisano pliku ");
                });
        }
        const selectFile = () => {
            document.getElementById("fileControllerSelect").click()
        }

        const refreshFiles = () => {
            getFiles(props.activity_id,props.file_type);
        }
        const removeFile =  async (id) => {
            await deleteFile(id)
            await nextTick()
            await refreshFiles()
        }
        return {
            files,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            showInfo,
            submitFile,
            selectFile,
            errors,
            removeFile,
        }
    },
    methods: {
    }
}
</script>
