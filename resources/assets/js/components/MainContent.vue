<template>
    <component :is="view"></component>
</template>

<script>
    import {bus} from "../app";

    export default {
        name: "main-content",
        props: {
            viewProp: {
                type: String,
                default: 'welcome'
            }
        },
        data: function () {
            return {
                view: this.viewProp
            }
        },
        created() {
            history.replaceState({view: this.view}, '', this.view);
            bus.$on('navigate', (view) => {
                this.view = view;
                this.pushHistory(this.view);
            });
            window.onpopstate = (event) => {
                this.view = event.state.view;
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
