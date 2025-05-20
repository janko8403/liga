<template>
    <ul class="breadcrumb">
        <li><a href="/">Strona główna</a></li>
        <li v-if="name">{{ name }}</li>
    </ul>
</template>
<script>

export default {
    props: {
        name: {},
    }
}
</script>
