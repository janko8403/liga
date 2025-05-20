<template>
    <div class="h3 mt-3 mb-3"><router-link :to="{ name: 'users.index' }"><i class="fa-solid fa-chevron-left" style="color:#000"></i></router-link> Agent | <span class="text-muted h3 ml-5"> {{ user.name }} {{ user.lastname }}</span></div>
    <div class="row justify-content-center mt-2">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <div className="mt-2 mb-6 text-sm text-red-600" v-if="errors !== ''">
                        {{ errors }}
                    </div>
                    <form class="row g-3" v-on:submit.prevent="saveUser">
                        <input type="hidden" name="_token" v-bind:value="csrf">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Imię</label>
                            <input type="text" disabled v-model="user.name" class="form-control" id="name">
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Nazwisko</label>
                            <input type="text" disabled v-model="user.lastname" class="form-control" id="lastname">
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label">Stanowisko</label>
                            <input type="text" disabled v-model="user.position" class="form-control" id="position">
                        </div>
                        <div class="col-md-6">
                            <label for="region" class="form-label">Region</label>
                            <input type="text" disabled v-model="user.region" class="form-control" id="region">
                        </div>
                        <div class="col-md-6">
                            <label for="njs" class="form-label">NJS</label>
                            <input type="text" disabled v-model="user.njs" class="form-control" id="njs">
                        </div>
                        <div class="col-md-6">
                            <label for="nepu" class="form-label">NEPU</label>
                            <input type="text" disabled v-model="user.nepu" class="form-control" id="nepu">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Telefon</label>
                            <input type="text" disabled v-model="user.phone" class="form-control" id="phone">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" disabled v-model="user.email" class="form-control" id="email">
                        </div>
                        <div class="col-12">

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body p-3">
                    <label class="form-label">Weryfikacja</label>
                    <div v-if="user.is_validated === 1" class="p-3">
                        <span class="badge text-bg-success p-3 mt-3">Pomyślna weryfikacja</span>
                    </div>
                    <div v-if="user.is_validated === 0" class="p-3">
                        <span class="badge text-bg-warning p-3">Brak weryfikacji</span>
                        <span class="small mx-4" v-if="user.last_verification_email"> Mail weryfikacyjny wysłano {{ user.last_verification_email}}</span>
                        <div class="btn btn-secondary mx-4" @click='sendVerificationEmail(user.id)' v-if="!user.last_verification_email">Wyślij email weryfikacyjny</div>
                    </div>
                    <div v-if="user.is_validated === 2" class="p-3">
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <img v-if="user.photo" style="max-width:100%" class="avatar" :src="user.photo.file_path">
                    <p class="p3" v-if="!user.photo">Brak zdjęcia</p>
                </div>
            </div>
            <div class="card mt-3" v-if="user.new_photo">
                <div class="card-body">
                    Propozycja Agenta
                    <div class="row">
                    <div class="col-12 mt-3">
                        <img style="max-width:100%" :src="user.new_photo.file_path" class="avatar" >
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Komentarz</label>
                        <textarea class="form-control" id="photo-comment" v-model="user.last_comment"></textarea>
                    </div>
                    <div class="col-6">
                        <span @click="updateUserPhoto(1)"
                                className="btn btn-danger" >
                            Odrzuć
                        </span>
                    </div>
                    <div class="col-6">
                        <button @click="updateUserPhoto(2)"
                                className="btn btn-primary">
                            Akceptuj
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useUsers from '../../../composables/backend/users';
import {onMounted, computed, nextTick} from 'vue';

export default {
    props: {
        id: {
            required: true,
            type: String
        }
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    setup(props) {
        const {errors, user, permissions, getUsersPermissions, sendUserVerificationEmail, saveUserPhoto, updateUser, getUser} = useUsers()
        onMounted(() => getUsersPermissions())
        onMounted(() => getUser(props.id))

        const saveUser = async () => {
            await updateUser(props.id)
        }

        const updateUserPhoto = async (v) => {
            await saveUserPhoto(props.id,v,document.getElementById('photo-comment').value);
            await nextTick();
            await getUser(props.id);
        }

        const is_validated = computed(() => {
            if (user.is_validated) {
                if (user.is_validated === 1) {
                    return 1;
                } else {
                    let date1 = new Date(user.last_verification_email);
                    let date2 = new Date();
                    let timeDiff = date2.getTime() - date1.getTime();
                    let diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    if (diffDays < -7) {
                        return 2;
                    } else {
                        return 0;
                    }
                }
            } else {
                return 3;
            }
        })

        const sendVerificationEmail = async (id) => {
            await sendUserVerificationEmail(id);
            await nextTick();
            await getUser(props.id);
        }

        return {
            errors,
            updateUserPhoto,
            sendVerificationEmail,
            is_validated,
            user,
            permissions,
            saveUser,
        }
    },

}
</script>
