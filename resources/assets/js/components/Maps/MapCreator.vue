<template>
    <div>
        <tools></tools>
        <site-map :map-id="routeId"></site-map>
    </div>
</template>

<script>
    export default {
        name: "map-creator",
        props: {
            routeId: {
                type: String,
                default: undefined
            }
        },
        created() {
            history.replaceState(
                {
                    view: 'map-creator',
                    routeId: this.routeId
                },
                '',
                'map-creator' + (this.routeId !== '' ? '?map=' + this.routeId : '')
            );
        },
        components: {
            tools: Vue.component('tools', function (resolve) {require(['./Tools'], resolve);}),
            'site-map': Vue.component('site-map', function (resolve) {require(['./SiteMap'], resolve);})
        }
    }
</script>

<style scoped>

</style>
