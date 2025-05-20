<template>
    <div class="card-results">
        <div class="title-header icon-font icon-color_g icon-font_lg" :class="icon_lg">{{title_lg}}</div>
    </div>
</template>

<script>
    export default {
        props: {
            title_lg: String,
            icon_lg: String,
        }
    }
</script>