<template>
    <div class="mt-3">
        <multiselect :v-model="ms-value" :options="voptions" label="name",
                     track-by="name"></multiselect>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
    props: ['value','options'],
    components: { Multiselect },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
