<template>
    <div>
        <div class="ui raised segment">
            <div class="ui header">Mapping Tools</div>
            <div class="ui divider"></div>
            <div class="ui basic icon buttons">
                <div class="ui icon basic button" ref="walk"><i class="blind icon"></i></div>
                <div class="ui button" @click="undo"><i class="undo icon"></i></div>
            </div>
            <div class="ui basic icon buttons">
                <div class="ui save map button" @click="save"><i class="save icon"></i></div>
                <div class="ui button" @click="download"><i class="download icon"></i></div>
            </div>
            <div class="ui icon basic buttons">
                <div class="ui cursor move button" @click="setMode($event, 'move')"><i
                        class="arrows alternate icon"></i></div>
                <div class="ui cursor edit active button" @click="setMode($event, 'edit')"><i
                        class="pencil alternate icon"></i></div>
            </div>
            <div class="ui icon basic buttons">
                <div class="ui icon basic labeled button dropdown" ref="scale">
                    <i class="expand arrows alternate icon"></i>
                    {{ scaleLabel }}
                    <div class="menu">
                        <div class="item" data-value="0.10" @click="setScale">
                            10%
                        </div>
                        <div class="item" data-value="0.25" @click="setScale">
                            25%
                        </div>
                        <div class="item" data-value="0.50" @click="setScale">
                            50%
                        </div>
                        <div class="item" data-value="1.0" @click="setScale">
                            100%
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui walk special popup top center">
            <div>Enter the path in the format you would use for the <em>walk</em> command.</div>
            <div class="ui action input">
                <input id="walk" type="text" value="" placeholder="e 2 n 4 ne 3" @keyup.enter="doWalk">
                <button class="ui right labeled icon button" @click="doWalk">
                    <i class="blind icon"></i>
                    Walk
                </button>
                <label for="walk"></label>
            </div>
        </div>
    </div>
</template>

<script>
    import {bus} from "../../app";

    export default {
        name: "tools",
        mounted() {
            $(this.$refs.walk).popup({
                popup: $('.walk.popup'),
                on: 'click',
                position: 'top center',
                onVisible: () => {
                    $('#walk').focus();
                }
            });
            $(this.$refs.scale).dropdown();
        },
        data: function () {
            return {
                scale: 0.10
            }
        },
        computed: {
            scaleLabel: function () {
                return (this.scale * 100) + '%';
            }
        },
        methods: {
            undo: function () {
                bus.$emit('undo');
            },
            download: function () {
                bus.$emit('download');
            },
            doWalk: function () {
                let input = $('#walk');
                let path = input.val().replace(/\s/g, '').toLowerCase();
                bus.$emit('walk', path);
                $(this.$refs.walk).popup('hide');
                input.val('');
            },
            setMode: function (event, mode) {
                $('.ui.cursor.button.active').removeClass('active');
                $(event.currentTarget).addClass('active');

                bus.$emit('mode', mode);
            },
            save: function () {
                bus.$emit('save-map');
            },
            setScale: function (event) {
                this.scale = $(event.currentTarget).data('value');
                bus.$emit('set-scale', this.scale);
            }
        }
    }
</script>

<style scoped>

</style>
