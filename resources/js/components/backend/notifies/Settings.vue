<template>
    <form class="row g-3" v-on:submit.prevent="saveSettings('1')">
        <input type="hidden" name="_token" v-bind:value="csrf">
        <div class="col-md-12 col-xs-12 mt-3">
            <div class="mb-3">
                <label class="form-label">Adres na który wysyłane są wiadomości z formularza kontaktowego</label>
                <input type="text" class="form-control" v-model="appSetting.content">
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-primary">Zapisz</button>
            </div>
        </div>
    </form>
</template>

<script>

import {nextTick, onMounted} from 'vue';
import useSettings from "../../../composables/backend/settings";

export default {
    props: {
        notify_id: {
            required: true,
        }
    },
    setup() {
        const { appSetting, getSetting, updateSettings } = useSettings()
        onMounted(() => getSetting('1'))

        const saveSettings = async (id) => {
            await updateSettings(id);
        }

        return {
            appSetting,
            saveSettings,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
}
</script>

