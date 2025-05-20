<template>
    <div class="h3 mt-3 mb-2">Administratorzy |<span class="text-muted h3"> Lista</span></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
        <a class="navbar-brand" href="#"></a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn btn-secondary me-2" href="/backend/admins/new">Nowy Administrator</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row justify-content-center mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">
                                    #
                                </th>
                                <th scope="col">
                                    Administrator
                                </th>
                                <th scope="col">
                                    Email
                                </th>
                                <th scope="col">
                                    Uprawnienia
                                </th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="item in admins" :key="item.id">
                                <tr>
                                    <th scope="row">
                                        {{ item.id }}
                                    </th>
                                    <td>
                                        {{ item.name }}
                                    </td>
                                    <td>
                                        {{ item.email }}
                                    </td>
                                    <td>
                                        <template v-if="item.permissions">{{ item.permissions.name }}</template>
                                    </td>
                                    <td>
                                        <span class="mr-2">
                                        <router-link :to="{ name: 'admins.edit', params: { id: item.id } }"
                                                     class="mr-2 btn btn-m">
                                            Edycja
                                        </router-link>
                                        </span>
                                        <button @click="deleteAdmin(item.id)"
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
            </div>
        </div>
    </div>
</template>

<script>
import useAdmins from '../../../composables/backend/admins'
import {nextTick, onMounted} from 'vue';

export default {
    setup() {
        const { admins, getAdmins, destroyAdmin } = useAdmins()

        const deleteAdmin = async (id) => {
            await destroyAdmin(id);
            await nextTick();
            await getAdmins()
        }

        onMounted(getAdmins)
        return {
            admins,
            deleteAdmin,
        }
    }
}
</script>
