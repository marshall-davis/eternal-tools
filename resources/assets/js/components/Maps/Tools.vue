<template>
    <div class="ui raised segment">
        <div class="ui header">Mapping Tools</div>
        <div class="ui divider"></div>
        <button class="ui icon basic button"><i class="blind icon"></i></button>
        <div class="ui basic icon buttons">
            <div class="ui button"><i class="save icon"></i></div>
            <div class="ui button" @click="undo"><i class="undo icon"></i></div>
            <div class="ui button"><i class="download icon" @click="download"></i></div>
        </div>
    </div>
</template>

<script>
    import {bus} from "../../app";

    export default {
        name: "tools",
        methods: {
            undo: function () {
                bus.$emit('undo');
            },
            download: function () {
                bus.$emit('download');
            }
        }
    }
</script>

<style scoped>

</style>
