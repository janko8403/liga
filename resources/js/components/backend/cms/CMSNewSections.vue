<template>
    <div class="mt-3">
        <div class="card-body">
            <div class="row">
                <template v-for="category in Object.keys(dictSections)">
                    <div class="col-12 mt-3">{{ category }}<hr></div>
                    <template v-for="section in dictSections[category]">
                    <div class="p-3 mt-2 col-md-3 col-xs-12">
                        <form v-on:submit.prevent="addSection(section.id,section.columns)">
                        <div class="card p-3 dp__pointer">
                            <div class="card-title">{{ section.name }}</div>
                            <div class="card-body">{{section.description}}</div>
                            <button class="btn btn-primary" type="submit">Dodaj</button>
                        </div>
                        </form>
                    </div>
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted } from "vue";
import useSections from "../../../composables/backend/cms-sections";

export default {
    props: {
        menu_id: {
            required: true
        }
    },

    setup(props,{emit}) {
        const { dictSections, storeSection, getSectionsDefinitions } = useSections()
        onMounted(() => getSectionsDefinitions())

        function addSection(id, columns) {
            const data = { order_id: 0, component_id: id, menu_id: props.menu_id, columns: columns}
            storeSection(data)
            emit('refresh_sections',props.menu_id);
        }

        return {
            dictSections,
            addSection
        }
    },
}
</script>
