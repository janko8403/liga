<template>
    <div class="container">

        <div class="row">
            <div class="col">
                <BreadCrumb name="Profil"></BreadCrumb>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card-results">
                    <h1>Profil użytkownika</h1>
                    <div class="row" v-if="user.photo">
                        <p class="p-4">
                            <img class="avatar" :src="user.photo.file_path" title="To ja">
                        </p>
                    </div>
                    <div class="row" v-if="!user.new_photo && !isPhotoSent">
                        <div class="col-md-6">
                            <p class="mt-5 pt-3 pb-5"><a class="btn-pzu btn-pzu_blue-border" href="#" v-on:click="selectFile">dodaj zdjęcie profilowe</a></p>
                            <form action="/api/frontend/avatar-upload" method="POST" ref="fileform" class="form-inline" enctype="multipart/form-data">
                                <input type="hidden" name="_token" :value="csrf">
                                <div class="form-group" style="max-width: 80px; margin: 0 auto;margin-bottom:10px;">
                                    <div class="custom-file">
                                        <input type="file" name="data-file" @change="handleHeaderFileUpload( $event, user.id )" class="custom-file-input" id="importFile" style="visibility: hidden">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row" v-if="user.new_photo || isPhotoSent">
                        <p class="p-5">
                            Nowe zdjęcie profilowe zostało wysłane i oczekuje na weryfikację
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="floating-label">
                                <span class="floating-input" v-html="user.name"></span>
                                <span class="highlight"></span>
                                <label>Imię</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="floating-label">
                                <span class="floating-input" v-html="user.lastname"></span>
                                <span class="highlight"></span>
                                <label>Nazwisko</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="floating-label">
                                <span class="floating-input" v-html="user.email"></span>
                                <span class="highlight"></span>
                                <label>E-mail</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="floating-label">
                                <span class="floating-input" v-html="user.mobile"></span>
                                <span class="highlight"></span>
                                <label>Telefon</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BreadCrumb from '../../../components/frontend/subcomponents/BreadCrumb'
import useCMS from "../../../composables/frontend/cms";
import {onMounted} from "vue";

    export default {
        setup() {
            const {user, getUserData} = useCMS()
            onMounted(() => getUserData())

            return {
                user,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        components: {
            BreadCrumb
        },
        data() {
            return {
                isPhotoSent: false,
            }
        },
        methods: {
            selectFile() {
                document.getElementById("importFile").click()
            },
            handleHeaderFileUpload(event, user) {
                let file = event.target.files[0];
                let formData = new FormData();
                formData.append('data-file', file);
                formData.append('activity_id', user)
                formData.append('type', 'user-new-avatar')
                try {
                    let response = axios.post('/api/frontend/avatar-upload',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(response => {
                        this.errors = "Zapisano dane"
                        this.isPhotoSent = true;
                    }).catch(result => {
                        this.errors = "Niepoprawny plik."
                        if (result.status === 422 && result.status === 400) {
                            for (const key in result.data.errors) {
                                this.errors += result.data.errors[key][0] + ' ';
                            }
                        }
                    });
                } catch (e) {
                    if (e.response && 419 === e.response.status) {
                        window.location.reload()
                    }
                    if (e.response.status === 422 && e.response.status === 400) {
                        for (const key in e.response.data.errors) {
                            this.errors += e.response.data.errors[key][0] + ' ';
                        }
                        this.showInfo()
                    }
                }

            },
        },
    }
</script>
