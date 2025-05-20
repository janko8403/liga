<template>
    <ul class="breadcrumb">
        <li><a href="/">Strona główna</a></li>
        <li v-if="section.page">{{ section.page.name }}</li>
    </ul>
</template>
<script>

export default {
    props: {
        section: {},
    }
}
</script>
