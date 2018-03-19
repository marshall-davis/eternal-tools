<template>
    <div>
        <tools></tools>
        <site-map></site-map>
    </div>
</template>

<script>
    export default {
        name: "map-creator",
        components: {
            tools: Vue.component('tools', function (resolve) {require(['./Tools'], resolve);}),
            'site-map': Vue.component('site-map', function (resolve) {require(['./SiteMap'], resolve);})
        }
    }
</script>

<style scoped>

</style>
