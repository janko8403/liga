<template>
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
            </tr>
            </thead>

            <tbody>
            <template v-for="item in users" :key="item.id">
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
                        {{ item.permissions }}
                    </td>
                    <td>
                        <router-link :to="{ name: 'users.edit', params: { id: item.id } }"
                                     class="mr-2 btn btn-primary">
                            Edycja
                        </router-link>
                        <button @click="destroyAdmin(item.id)"
                                class="btn btn-danger">
                            Usuń
                        </button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
import useAdmins from '../../../composables/backend/users'
import { onMounted } from 'vue';

export default {
    setup() {
        const { admins, getUsers } = useUsers()

        onMounted(getUsers)

        return {
            users,
        }
    }
}
</script>
