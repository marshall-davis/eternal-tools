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
            <div class="ui icon basic buttons">
                <div class="ui icon basic button" ref="color">
                    <i class="stop icon" :style="'color: ' + this.color + ';'"></i>
                </div>
                <div class="ui basic labeled button dropdown" ref="size">
                    {{ size }}
                    <div class="menu">
                        <div class="item" data-value="10">10</div>
                        <div class="item" data-value="20">20</div>
                        <div class="item" data-value="40">40</div>
                        <div class="item" data-value="80">80</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui color special popup bottom center">
            <div class="ui equal width grid">
                <div class="equal width row">
                    <div class="column">
                        <div class="ui icon basic button" data-tooltip="Forest" @click="setColor('#698e6c')">
                            <i class="stop icon" style="color: #698e6c"></i>
                        </div>
                        <div class="ui icon basic button" data-tooltip="Grass" @click="setColor('#caca80')">
                            <i class="stop icon" style="color: #caca80"></i>
                        </div>
                        <div class="ui icon basic button" data-tooltip="Road" @click="setColor('#bdbdbd')">
                            <i class="stop icon" style="color: #bdbdbd"></i>
                        </div>
                    </div>
                </div>
                <div class="equal width row">
                    <div class="column">
                        <div class="ui labeled input">
                            <div class="ui label">
                                Custom
                            </div>
                            <input type="text" v-model="color" :placeholder="color" @blur="setColor()" @keyup.enter="hideColorControl">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui walk special popup bottom center">
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
                position: 'bottom center',
                onVisible: () => {
                    $('#walk').focus();
                }
            });
            $(this.$refs.color).popup({
                popup: $('.color.popup'),
                on: 'click',
                position: 'bottom center',
            });
            $(this.$refs.scale).dropdown();
            $(this.$refs.size).dropdown();
        },
        data: function () {
            return {
                scale: 0.10,
                color: '#698e6c',
                size: 80
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
            },
            hideColorControl: function () {
                $(this.$refs.color).popup('hide');
            },
            setColor: function (color) {
                this.color = color || this.color;
                bus.$emit('set-color', this.color);
                this.hideColorControl();
            }
        }
    }
</script>

<style scoped>

</style>
