<template>
    <div class="ui segment map">
        <canvas id="map-canvas" ref="canvas" :style="style" v-on:mousedown="handleClick" v-on:mousemove="drag"
                v-on:mouseup="stopDragging"></canvas>
        <map-image :deltas="deltas"></map-image>
    </div>
</template>

<script>
    import {bus} from '../../app'

    export default {
        name: "site-map",
        props: {
            mapId: {
                type: String,
                default: undefined,
            },
        },
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
                dragStart: {},
                map: this.mapId,
                totalTranslation: {
                    x: 0,
                    y: 0,
                },
                centerPosition: {},
            }
        },
        computed: {
            style: function () {
                return 'cursor: ' + this.canvasCursor + ';';
            },
            roomSize: function () {
                return Math.floor(this.size * this.scale);
            },
            lastDelta: function () {
                return this.deltas[this.deltas.length - 1];
            },
        },
        created() {
            bus.$on('undo', () => {
                this.undo();
            });
            bus.$on('walk', (path) => {
                this.walk(path);
            });
            bus.$on('mode', mode => this.setMode(mode));
            bus.$on('save-map', () => {
                this.save();
            });
            bus.$on('set-scale', scale => {
                this.scaleTo(scale);
            });
            bus.$on('set-color', color => {
                this.canvasContext.fillStyle = color;
            });
            bus.$on('set-size', size => {
                this.size = size;
                this.canvasContext.fillStyle = 'red';
            });
        },
        mounted() {
            Vue.nextTick(() => {
                this.$refs.canvas.width = this.$refs.canvas.offsetWidth;
                this.$refs.canvas.height = this.$refs.canvas.offsetHeight;
                this.canvasContext = this.$refs.canvas.getContext('2d');
                this.canvasContext.fillStyle = '#698e6c';
                this.findMapPosition();

                Vue.nextTick(() => {
                    this.centerPosition = {
                        x: Math.floor((this.$refs.canvas.width / 2)),
                        y: Math.floor((this.$refs.canvas.height / 2)),
                    };
                    this.changePosition(this.centerPosition);

                    this.addDelta({
                        position: this.position,
                        size: this.size,
                        color: this.canvasContext.fillStyle,
                    });
                    this.draw();
                });

                if (this.mapId) {
                    axios.get('/api/maps/' + this.mapId).then(response => {
                        this.deltas = JSON.parse(response.data.steps);
                        this.redraw();
                    });
                }
            });
        },
        methods: {
            findMapPosition: function () {
                this.mapPosition = {
                    y: this.$refs.canvas.getBoundingClientRect().top + window.pageYOffset,
                    x: this.$refs.canvas.getBoundingClientRect().left + window.pageXOffset,
                };
            },
            draw: function () {
                let boxPosition = {
                    x: Math.floor(this.position.x - (this.roomSize / 2)),
                    y: Math.floor(this.position.y - (this.roomSize / 2)),
                };

                console.log('Drawing room at', {x: boxPosition.x, y: boxPosition.y}, 'sized', this.roomSize);
                this.canvasContext.fillRect(
                    boxPosition.x,
                    boxPosition.y,
                    this.roomSize,
                    this.roomSize,
                );
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
                this.dragging = true;
                this.dragStart = {
                    x: event.pageX,
                    y: event.pageY,
                };
            },
            stopDragging: function () {
                if (this.dragging) {
                    this.dragging = false;
                    this.dragStart = {};
                }
            },
            drag: function (event) {
                if (this.dragging) {
                    this.findMapPosition();
                    let position = {
                        x: event.pageX,
                        y: event.pageY,
                    };

                    let translation = {
                        x: position.x - this.dragStart.x,
                        y: position.y - this.dragStart.y,
                    };

                    this.canvasContext.translate(translation.x, translation.y);
                    this.totalTranslation = {
                        x: this.totalTranslation.x + translation.x,
                        y: this.totalTranslation.y + translation.y,
                    };

                    this.dragStart = position;
                    this.redraw();
                }
            },
            possibleRooms: function () {
                let divisor = this.lastDelta ? this.lastDelta.size : this.size;
                let perSide = divisor / this.size;
                console.log('Possible rooms per side', perSide);
                let possiblePoints = {};
                let cardinalPoints = {};

                possiblePoints.ne = this.shiftDirection('ne');
                possiblePoints.se = this.shiftDirection('se');
                possiblePoints.nw = this.shiftDirection('nw');
                possiblePoints.sw = this.shiftDirection('sw');

                cardinalPoints.n = this.shiftDirection('n');
                cardinalPoints.e = this.shiftDirection('e');
                cardinalPoints.s = this.shiftDirection('s');
                cardinalPoints.w = this.shiftDirection('w');

                if (perSide === 2) {
                    let nudge = this.lastDelta.size / 2;
                    possiblePoints.nNudgeE = {
                        x: cardinalPoints.n.x + nudge,
                        y: cardinalPoints.n.y,
                    };
                    possiblePoints.nNudgeW = {
                        x: cardinalPoints.n.x - nudge,
                        y: cardinalPoints.n.y,
                    };
                    possiblePoints.eNudgeN = {
                        x: cardinalPoints.e.x,
                        y: cardinalPoints.e.y + nudge,
                    };
                    possiblePoints.eNudgeS = {
                        x: cardinalPoints.e.x,
                        y: cardinalPoints.e.y - nudge,
                    };
                    possiblePoints.sNudgeE = {
                        x: cardinalPoints.s.x + nudge,
                        y: cardinalPoints.s.y,
                    };
                    possiblePoints.sNudgeW = {
                        x: cardinalPoints.s.x - nudge,
                        y: cardinalPoints.s.y,
                    };
                    possiblePoints.wNudgeN = {
                        x: cardinalPoints.w.x,
                        y: cardinalPoints.w.y + nudge,
                    };
                    possiblePoints.wNudgeS = {
                        x: cardinalPoints.w.x,
                        y: cardinalPoints.w.y - nudge,
                    };
                } else {
                    possiblePoints = Object.assign(cardinalPoints, possiblePoints);
                }

                return possiblePoints;
            },
            findClosetPossibleTo(x, y) {
                let closest = undefined;
                let currentMinimumDistance = undefined;
                let possibilities = this.possibleRooms();

                for (const direction in possibilities) {
                    if (possibilities.hasOwnProperty(direction)) {
                        let distance = Math.sqrt(Math.pow((x - possibilities[direction].x), 2) + Math.pow(y - possibilities[direction].y, 2));

                        if (distance < currentMinimumDistance || currentMinimumDistance === undefined) {
                            currentMinimumDistance = distance;
                            closest = direction;
                        }
                    }
                }

                return closest;
            },
            drawClick: function (event) {
                let direction = this.findClosetPossibleTo(
                    event.pageX - this.mapPosition.x - this.totalTranslation.x,
                    event.pageY - this.mapPosition.y - this.totalTranslation.y,
                );

                this.changePosition(this.shiftDirection(direction));
                this.addDelta({
                    position: this.position,
                    direction: direction,
                    size: this.size,
                    color: this.canvasContext.fillStyle,
                });
                this.draw();
                this.markPosition();
            },
            changePosition: function (to) {
                this.position = {
                    x: to.x,
                    y: to.y,
                };
                this.markPosition();
            },
            markPosition: function () {
                // console.log(this.position.x, this.position.y)
            },
            drawLine: function (fromPoint, toPoint, color) {
                console.log('Drawing from', fromPoint.x, fromPoint.y, 'to', toPoint.x, toPoint.y);
                let originalStroke = this.canvasContext.strokeStyle;
                let originalLineWidth = this.canvasContext.lineWidth;
                this.canvasContext.strokeStyle = color;
                this.canvasContext.lineWidth = 5;
                this.canvasContext.beginPath();
                this.canvasContext.moveTo(fromPoint.x, fromPoint.y);
                this.canvasContext.lineTo(toPoint.x, toPoint.y);
                this.canvasContext.stroke();
                this.canvasContext.strokeStyle = originalStroke;
                this.canvasContext.lineWidth = originalLineWidth;
            },
            undo: function () {
                console.log('Removing last');
                let last = this.deltas.pop();
                if (last) {
                    let size = last.size * this.scale;
                    this.canvasContext.clearRect(
                        last.position.x - (size / 2),
                        last.position.y - (size / 2),
                        size,
                        size,
                    );

                    let previous = this.deltas[this.deltas.length - 1];
                    this.changePosition(previous ? previous.position : this.centerPosition);
                }
            },
            walk: function (path) {
                path.split(/([enswud]{1,2}\d+)/i)
                    .filter(segment => segment.length)
                    .forEach((segment) => {
                        let direction = segment.substr(0, segment.search(/\d/));
                        let distance = segment.substr(segment.search(/\d/));
                        for (let pace = 0; pace < distance; pace++) {
                            this.changePosition(this.shiftDirection(direction));
                            this.addDelta({
                                position: this.position,
                                direction: direction,
                                size: this.size,
                                color: this.canvasContext.fillStyle,
                            });
                            this.draw();
                        }
                    });
                this.draw();
                this.markPosition();
            },
            shiftDirection: function (direction) {
                let newPosition = {
                    x: this.position.x,
                    y: this.position.y,
                };

                if (['n', 'ne', 'nw'].includes(direction)) {
                    newPosition.y = newPosition.y - this.roomSize - 2;
                }
                if (['e', 'ne', 'se'].includes(direction)) {
                    newPosition.x = newPosition.x + this.roomSize + 2;
                }
                if (['s', 'se', 'sw'].includes(direction)) {
                    newPosition.y = newPosition.y + this.roomSize + 2;
                }
                if (['w', 'sw', 'nw'].includes(direction)) {
                    newPosition.x = newPosition.x - this.roomSize - 2;
                }

                return newPosition;
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
                this.position = this.centerPosition;
                this.clearCanvas();

                let originalFillStyle = this.canvasContext.fillStyle;
                let originalSize = this.size;
                this.deltas.forEach((delta) => {
                    this.canvasContext.fillStyle = delta.color;
                    this.changePosition(this.shiftDirection(delta.direction));
                    this.size = delta.size;
                    if (delta.path) {
                        this.walk(delta.path);
                    } else {
                        this.draw();
                    }
                });
                this.canvasContext.fillStyle = originalFillStyle;
                this.size = originalSize;
            },
            save: function () {
                if (this.map) {
                    this.update();
                } else {
                    this.create();
                }
            },
            create: function () {
                axios.post('/api/maps', {
                    steps: JSON.stringify(this.deltas),
                    map: this.map,
                }).then((response) => {
                    this.map = response.data.id;
                    history.replaceState(
                        {
                            view: 'map-creator',
                            map: response.data.id,
                        },
                        '',
                        '/map-creator?map=' + response.data.id,
                    );
                    bus.$emit('toast', {
                        type: 'success',
                        title: 'Map Has Been Saved.',
                        message: 'You can use the URL in your address bar to return to this map.',
                        options: {
                            closeButton: true,
                            timeOut: 0,
                            extendedTimeOut: 0,
                            positionClass: 'toast-top-center',
                        },
                    });
                });
            },
            update: function () {
                axios.put('/api/maps/' + this.map, {
                    steps: JSON.stringify(this.deltas),
                }).then(() => {
                    bus.$emit('toast', {
                        type: 'success',
                        message: 'Map Has Been Saved.',
                        options: {
                            closeButton: false,
                            positionClass: 'toast-bottom-center',
                        },
                    });
                });
            },
            scaleTo: function (scale) {
                this.scale = scale;
                this.redraw();
            },
        },
        components: {
            'map-image': Vue.component('map-image', function (resolve) {
                require(['./MapImage'], resolve);
            }),
        },
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
