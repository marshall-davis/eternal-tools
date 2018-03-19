<template>
    <div class="ui segment map">
        <canvas id="map-canvas" ref="canvas" @click="handleClick"></canvas>
    </div>
</template>

<script>
    import {bus} from '../../app'

    export default {
        name: "site-map",
        data: function () {
            return {
                canvasContext: undefined,
                position: {},
                scale: 0.10,
                size: 80,
                deltas: []
            }
        },
        created() {
            bus.$on('undo', () => {
                this.undo()
            })
        },
        mounted() {
            this.position = {
                x: this.$refs.canvas.width / 2,
                y: this.$refs.canvas.height / 2
            };
            Vue.nextTick(() => {
                this.$refs.canvas.width = this.$refs.canvas.offsetWidth;
                this.$refs.canvas.height = this.$refs.canvas.offsetHeight;
                this.canvasContext = this.$refs.canvas.getContext('2d');
                this.canvasContext.fillStyle = 'green';
            });
        },
        methods: {
            draw: function () {
                let boxSize = Math.floor(this.size * this.scale);
                let mapPosition = {
                    y: this.$refs.canvas.getBoundingClientRect().top + window.pageYOffset,
                    x: this.$refs.canvas.getBoundingClientRect().left + window.pageXOffset
                };
                let boxPosition = {
                    x: Math.floor(Math.abs((this.position.x - mapPosition.x)) - (boxSize / 2)),
                    y: Math.floor(Math.abs((this.position.y - mapPosition.y)) - (boxSize / 2)),
                };
                this.canvasContext.fillRect(
                    boxPosition.x,
                    boxPosition.y,
                    boxSize,
                    boxSize
                );
                this.addDelta({
                    position: boxPosition,
                    size: boxSize,
                    color: this.canvasContext.fillStyle
                });
            },
            addDelta: function (delta) {
                this.deltas.push(delta);
            },
            handleClick: function (event) {
                this.changePosition(event.pageX, event.pageY);
                this.draw();
            },
            changePosition: function (x, y) {
                this.position = {
                    x: x,
                    y: y
                }
            },
            undo: function () {
                console.log('Removing last');
                let last = this.deltas.pop();
                if (last) {
                    this.canvasContext.clearRect(last.position.x, last.position.y, last.size, last.size);
                }
            }
        }
    }
</script>

<style scoped>
    .ui.segment.map {
        min-height: 20rem;
        overflow: hidden;
    }

    canvas {
        width: 100%;
        min-height: 20rem
    }
</style>
