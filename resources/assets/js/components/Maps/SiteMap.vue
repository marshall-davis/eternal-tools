<template>
    <div class="ui segment map">
        <canvas id="map-canvas" ref="canvas" @click="handleClick"></canvas>
    </div>
</template>

<script>
    export default {
        name: "site-map",
        data: function () {
            return {
                canvasContext: undefined,
                position: {},
                scale: 0.10,
                size: 80
            }
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
                let boxSize = this.size * this.scale;
                let mapPosition = {
                    y: this.$refs.canvas.getBoundingClientRect().top + window.pageYOffset,
                    x: this.$refs.canvas.getBoundingClientRect().left + window.pageXOffset
                };
                console.log(this.position.x, this.$refs.canvas.getBoundingClientRect().top);
                this.canvasContext.fillRect(
                    Math.abs((this.position.x - mapPosition.x)) - (boxSize / 2),
                    Math.abs((this.position.y - mapPosition.y)) - (boxSize / 2),
                    boxSize,
                    boxSize
                );
            },
            handleClick: function (event) {
                console.log('Map clicked.', event.pageX, event.pageY, event);
                this.changePosition(event.pageX, event.pageY);
                this.draw();
            },
            changePosition: function (x, y) {
                this.position = {
                    x: x,
                    y: y
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
