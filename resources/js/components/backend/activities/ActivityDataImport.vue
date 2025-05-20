<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-4">
        <div class="navbar-brand">Dane</div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item" v-if="show_import">
                    <div style="visibility:hidden">
                        <input type="file" id="fileControllerSelect" ref="file" v-on:change="submitFile($event)"/>
                    </div>
                    <button class="btn btn-secondary" v-on:click="selectFile()">Import</button>
                </li>
                <li class="nav-item" v-if="show_export">
                    <a class="btn btn-secondary ms-2" :href="exportLink" title="Eksport danych w formacie XLS" style="margin-top:30px;">Eksport</a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import {useToast} from "bootstrap-vue-3";

export default {
    props: {
        activity_id: {
            required: true,
        },
        show_import: {},
        show_export: {},
        type: {
            required: true,
        },
        edition_id: {
            required: true,
        },
    },
    setup(props) {
        let rowsTotal = 0;
        let rowsValid = 0;
        let rowsInvalid = 0;
        let toast = useToast()
        let showInfo = (info) => {
            toast.show({title: info })
        }
        const submitFile = async (event) => {
            let file = event.target.files[0];
            let formData = new FormData();
            showInfo("Rozpoczęto import");
            formData.append('data-file', file);
            formData.append('activity_id', props.activity_id);
            formData.append('edition_id', props.edition_id);
            formData.append('type', props.type);

            let response = axios.post('/backend/data-import',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(response => {
                if (response.data["rowsTotal"]>0) {
                    showInfo('Poprawne ' + response.data["rowsValid"] + ' Błędne ' + response.data["rowsInvalid"]);
                    showInfo('Zakończono import');
                }
            })
                .catch(function(){
                    showInfo(response.data["zonk"]);
                });
        }

        const selectFile = () => {
            document.getElementById("fileControllerSelect").click()
        }

        return {
          rowsTotal,
          rowsValid,
          selectFile,
          rowsInvalid,
          submitFile,
          csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

      }
    },
    computed: {
        exportLink(props) {
            return "/backend/data-export/"+props.type+"/"+props.activity_id+"/"+props.edition_id;
        }
    }

}
</script>
