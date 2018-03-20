<template>
    <component :is="view" :route-id="routeId"></component>
</template>

<script>
    import {bus} from "../app";

    export default {
        name: "main-content",
        props: {
            viewProp: {
                type: String,
                default: 'welcome'
            },
            routeId: {
                type: String,
                default: undefined
            }
        },
        data: function () {
            return {
                view: this.viewProp
            }
        },
        created() {
            history.replaceState(
                {
                    view: this.view,
                    routeId: this.routeId
                },
                '',
                this.view
            );
            bus.$on('navigate', (view) => {
                this.view = view;
                this.pushHistory(this.view);
            });
            window.onpopstate = (event) => {
                this.view = event.state.view;
                this.routeId = event.state.routeId
            }
        },
        methods: {
            pushHistory: (path) => {
                history.pushState({view: path}, '', '/' + path);
            }
        }
    }
</script>

<style scoped>

</style>
