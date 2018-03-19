<template>
    <div class="ui segment map">
        <canvas id="map-canvas" ref="canvas" :style="style" v-on:mousedown="handleClick" v-on:mousemove="drag"
                v-on:mouseup="stopDragging"></canvas>
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
                deltas: [],
                mapPosition: {},
                canvasCursor: 'auto',
                mode: 'edit',
                dragging: false,
                dragStart: {}
            }
        },
        computed: {
            style: function () {
                return 'cursor: ' + this.canvasCursor + ';';
            }
        },
        created() {
            bus.$on('undo', () => {
                this.undo();
            });
            bus.$on('download', () => {
                this.download();
            });
            bus.$on('walk', (path) => {
                this.walk(path);
            });
            bus.$on('mode', mode => this.setMode(mode));
        },
        mounted() {
            Vue.nextTick(() => {
                this.$refs.canvas.width = this.$refs.canvas.offsetWidth;
                this.$refs.canvas.height = this.$refs.canvas.offsetHeight;
                this.canvasContext = this.$refs.canvas.getContext('2d');
                this.canvasContext.fillStyle = 'green';
                this.findMapPosition();

                Vue.nextTick(() => {
                    console.log('Canvas width', this.$refs.canvas.width, Math.floor(this.$refs.canvas.width / 2), 'Canvas height', this.$refs.canvas.height, Math.floor(this.$refs.canvas.height / 2));
                    console.log('Canvas at', this.mapPosition.x, this.mapPosition.y);
                    this.changePosition(
                        Math.floor((this.$refs.canvas.width / 2)),
                        Math.floor((this.$refs.canvas.height / 2))
                    );
                });
            });
        },
        methods: {
            findMapPosition: function () {
                this.mapPosition = {
                    y: this.$refs.canvas.getBoundingClientRect().top + window.pageYOffset,
                    x: this.$refs.canvas.getBoundingClientRect().left + window.pageXOffset
                };
            },
            draw: function () {
                let boxSize = Math.floor(this.size * this.scale);
                let boxPosition = {
                    x: Math.floor(this.position.x - (boxSize / 2)),
                    y: Math.floor(this.position.y - (boxSize / 2)),
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
            download: function () {
                let link = document.createElement('a');
                link.addEventListener('click', () => {
                    link.href = this.$refs.canvas.toDataURL();
                    link.download = "map.png";
                }, false);
                link.click();
            },
            addDelta: function (delta) {
                this.deltas.push(delta);
            },
            handleClick: function (event) {
                if (this.mode === 'edit') {
                    this.drawClick(event);
                } else {
                    this.startDragging(event);
                }
            },
            startDragging: function (event) {
                console.log('Starting drag.');
                this.dragging = true;
                this.dragStart = {
                    x: event.pageX - this.mapPosition.x,
                    y: event.pageY - this.mapPosition.y
                };
            },
            stopDragging: function () {
                if (this.dragging) {
                    console.log('Ending drag.');
                    this.dragging = false;
                    this.dragStart = {};
                }
            },
            drag: function (event) {
                if (this.dragging) {
                    this.findMapPosition();
                    let position = {
                        x: event.pageX - this.mapPosition.x,
                        y: event.pageY - this.mapPosition.y
                    };

                    let translation = {
                        x: position.x - this.dragStart.x,
                        y: position.y - this.dragStart.y
                    };
                    console.log('Translating', translation.x, translation.y);
                    this.canvasContext.translate(translation.x, translation.y);
                    this.dragStart = position;
                    this.redraw();
                }
            },
            drawClick: function (event) {
                this.changePosition(event.pageX - this.mapPosition.x, event.pageY - this.mapPosition.y);
                this.draw();
            },
            changePosition: function (x, y) {
                this.position = {
                    x: x,
                    y: y
                };
            },
            drawLine: function (fromPoint, toPoint) {
                console.log('Drawing from', fromPoint.x, fromPoint.y, 'to', toPoint.x, toPoint.y);
                this.canvasContext.beginPath();
                this.canvasContext.moveTo(fromPoint.x, fromPoint.y);
                this.canvasContext.lineTo(toPoint.x, toPoint.y);
                this.canvasContext.stroke();
            },
            undo: function () {
                console.log('Removing last');
                let last = this.deltas.pop();
                if (last) {
                    this.canvasContext.clearRect(last.position.x, last.position.y, last.size, last.size);
                }
            },
            walk: function (path) {
                path.toLowerCase()
                    .split(/([enswud]{1,2}\d+)/i)
                    .filter(segment => segment.length)
                    .forEach((segment) => {
                        let direction = segment.substr(0, segment.search(/\d/));
                        let distance = segment.substr(segment.search(/\d/));
                        console.log('Going', direction, distance);
                        for (let pace = 0; pace < distance; pace++) {
                            this.shiftDirection(direction);
                            this.draw();
                        }
                    });
            },
            shiftDirection: function (direction) {
                if (['n', 'ne', 'nw'].includes(direction)) {
                    this.changePosition(this.position.x, this.position.y - (this.size * this.scale) - 2);
                }
                if (['e', 'ne', 'se'].includes(direction)) {
                    this.changePosition(this.position.x + (this.size * this.scale) + 2, this.position.y);
                }
                if (['s', 'se', 'sw'].includes(direction)) {
                    this.changePosition(this.position.x, this.position.y + (this.size * this.scale) + 2);
                }
                if (['w', 'sw', 'nw'].includes(direction)) {
                    this.changePosition(this.position.x - (this.size * this.scale) - 2, this.position.y);
                }
            },
            setMode: function (mode) {
                this.mode = mode;
                this.canvasCursor = this.mode === 'edit' ? 'auto' : 'move';
            },
            clearCanvas: function () {
                this.canvasContext.clearRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
                this.canvasContext.save();
                this.canvasContext.setTransform(1, 0, 0, 1, 0, 0);
                this.canvasContext.clearRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
                this.canvasContext.restore();
            },
            redraw: function () {
                this.clearCanvas();

                let originalFillStyle = this.canvasContext.fillStyle;
                this.deltas.forEach((delta) => {
                    this.canvasContext.fillStyle = delta.color;
                    this.canvasContext.fillRect(
                        delta.position.x,
                        delta.position.y,
                        delta.size,
                        delta.size
                    );
                });
                this.canvasContext.fillStyle = originalFillStyle;
            }
        }
    }
</script>

<style scoped>
    .ui.segment.map {
        height: 40rem;
        overflow: hidden;
    }

    canvas {
        width: 100%;
        min-height: 40rem
    }
</style>
