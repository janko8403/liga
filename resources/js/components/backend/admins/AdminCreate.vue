<template>
    <div class="h3 mt-3 mb-3">
        <router-link :to="{ name: 'admins.index' }">
            <i class="fa-solid fa-chevron-left" style="color:#000"></i>
        </router-link> Nowy Administrator
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3" v-on:submit.prevent="saveAdmin">
                        <input type="hidden" name="_token" v-bind:value="csrf">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Imię</label>
                            <input type="text" v-model="admin.name" class="form-control" id="name">
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Nazwisko</label>
                            <input type="text" v-model="admin.lastname" class="form-control" id="lastname">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" v-model="admin.email" class="form-control" id="email">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Hasło</label>
                            <input type="password" v-model="admin.password" class="form-control" id="password">
                        </div>
                        <div class="col-md-6">
                            <label for="permissions" class="form-label">Uprawnienia</label>
                            <multiselect v-model="admin.permissions" :options="adminPermissions"
                                         label="name"
                                         track-by="id"
                                         :multiple="false"
                                         selectLabel="Wybierz"
                                         selectedLabel="Wybrano"
                                         deselect-label="Usuń"
                                         placeholder="Wybierz"
                                         :close-on-select="true"
                                         :clear-on-select="false">
                            </multiselect>
                        </div>
                        <div class="col-6" >
                            <div style="margin-left:auto;padding-top:32px" align="right">
                                <button type="submit" className="btn btn-primary">
                                    Zapisz
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useAdmins from '../../../composables/backend/admins';
import {onMounted, nextTick, reactive} from 'vue';
import multiselect from 'vue-multiselect';


export default {
    props: {

    },
    components: {
        multiselect,
    },
    setup(props) {
        const {errors, adminPermissions, storeAdmin, getAdminsPermissions} = useAdmins()
        const admin = reactive({
            name: "",
            lastname: "",
            email: "",
            password: "",
            permissions: ""
        });

        onMounted(() => getAdminsPermissions())
        const saveAdmin = async () => {
            await storeAdmin(admin)
        }

        return {
            errors,
            admin,
            adminPermissions,
            saveAdmin,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    }
}
</script>
