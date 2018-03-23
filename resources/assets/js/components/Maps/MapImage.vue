<template>
    <div ref="mapElement">
    </div>
</template>

<script>
    import {bus} from '../../app'

    export default {
        name: "map-download",
        props: {
            deltas: {
                required: true,
                default: []
            },
            maxDimensions: {
                default: 5000
            },
            imagePadding: {
                default: 100
            },
            shouldRender: {
                default: false
            },
            roomPadding: {
                default: 2
            }
        },
        data: function () {
            return {
                scale: 1.0,
                canvas: undefined,
                context: undefined,
                minimumDimensions: {
                    height: {
                        value: 0,
                        delta: undefined
                    },
                    width: {
                        value: 0,
                        delta: undefined
                    }
                },
                maximumDimensions: {
                    height: {
                        value:0,
                        delta: undefined
                    },
                    width: {
                        value: 0,
                        delta: undefined
                    }
                }
            }
        },
        computed: {
            imageDimensions: function () {
                return this.maxDimensions - (this.imagePadding * 2);
            },
            canvasHeight: function () {
                let position = {x: 0, y: 0};
                this.deltas.forEach((delta, index) => {
                    let boxSize = Math.ceil(delta.size * this.scale);
                    position = this.shiftDirection(position, delta.direction, boxSize);

                    // Track how far from the original the image reaches.
                    let trackPosition = position.y < 0 ? position.y - (boxSize / 2) : position.y + (boxSize / 2);
                    this.trackDimension('height', trackPosition, index);
                });

                let height = this.imagePadding + Math.abs(this.maximumDimensions.height.value - this.minimumDimensions.height.value);
                this.setScale(height);

                return height;
            },
            canvasWidth: function () {
                let position = {x: 0, y: 0};
                this.deltas.forEach((delta, index) => {
                    let boxSize = Math.ceil(delta.size * this.scale);
                    position = this.shiftDirection(position, delta.direction, boxSize);

                    // Track how far from the original the image reaches.
                    let trackPosition = position.x < 0 ? position.x - (boxSize / 2) : position.x + (boxSize / 2);
                    this.trackDimension('width', trackPosition, index);
                });

                let width = this.imagePadding + Math.abs(this.maximumDimensions.width.value - this.minimumDimensions.width.value);
                this.setScale(width);

                return width;
            },
            dataUrl: function () {
                return this.canvas.toDataURL();
            }
        },
        created: function () {
            bus.$on('download', this.download);
        },
        methods: {
            download: function () {
                this.draw();

                let link = document.createElement('a');
                link.addEventListener('click', () => {
                    link.href = this.canvas.toDataURL();
                    link.download = "map.png";
                }, false);
                link.click();
            },
            setScale: function (dimension) {
                let factor = this.imageDimensions / dimension;

                this.scale = (this.scale > factor) ? factor : this.scale;
            },
            shiftDirection: function (fromPoint, direction, boxSize) {
                let newPosition = {
                    x: fromPoint.x,
                    y: fromPoint.y
                };

                if (['n', 'ne', 'nw'].includes(direction)) {
                    newPosition.y = newPosition.y - boxSize - this.roomPadding;
                }
                if (['e', 'ne', 'se'].includes(direction)) {
                    newPosition.x = newPosition.x + boxSize + this.roomPadding;
                }
                if (['s', 'se', 'sw'].includes(direction)) {
                    newPosition.y = newPosition.y + boxSize + this.roomPadding;
                }
                if (['w', 'sw', 'nw'].includes(direction)) {
                    newPosition.x = newPosition.x - boxSize - this.roomPadding;
                }

                return newPosition;
            },
            trackDimension: function (dimension, value, index) {
                if (this.minimumDimensions[dimension].value > value || this.minimumDimensions[dimension].value === 0) {
                    if (dimension === 'width') {
                        console.log('Tracking minimum to', value);
                    }
                    this.minimumDimensions[dimension].value = value;
                    this.minimumDimensions[dimension].delta = index;
                }

                if (this.maximumDimensions[dimension].value < value) {
                    if (dimension === 'width') {
                        console.log('Tracking maximum to', value);
                    }
                    this.maximumDimensions[dimension].value = value;
                    this.maximumDimensions[dimension].delta = index;
                }
            },
            draw: function () {
                // Build the canvas to draw on.
                this.canvas = document.createElement('canvas');
                this.context = this.canvas.getContext('2d');
                console.log('Canvas', this.canvasWidth, this.canvasHeight);
                this.canvas.setAttribute('width', this.canvasWidth);
                this.canvas.setAttribute('height', this.canvasHeight);

                // Translate the image to center it in the field.
                let xTranslation = 0;
                let yTranslation = 0;
                console.log('Point furthest left', this.minimumDimensions.width.value);
                if (this.minimumDimensions.width.value < 0) {
                    xTranslation = -1 * this.minimumDimensions.width.value;
                } else {
                    xTranslation = this.minimumDimensions.width.value;
                }
                console.log('Point furthest up', this.minimumDimensions.height.value);
                if (this.minimumDimensions.height.value) {
                    yTranslation = (this.minimumDimensions.height.value * -1);
                } else {
                    yTranslation = this.minimumDimensions.height.value;
                }

                console.log('Translating by', xTranslation, yTranslation);
                this.context.translate(xTranslation, yTranslation);

                console.log('Drawing background image.');
                let position = {x: 0, y: 0};

                // Iterate over the deltas to recreate the image.
                this.deltas.forEach((delta) => {
                    let boxSize = Math.ceil(delta.size * this.scale);
                    this.context.fillStyle = delta.color;
                    position = this.shiftDirection(position, delta.direction, boxSize);

                    this.context.fillRect(
                        Math.ceil(position.x - (boxSize / 2)),
                        Math.ceil(position.y - (boxSize / 2)),
                        boxSize,
                        boxSize
                    );
                });
            },
            render: function () {
                this.draw();

                let image = document.createElement('img');
                image.setAttribute('href', this.dataUrl);

                this.$refs.mapElement.append(image);
            }
        },
        mounted: function () {
            console.log('Image component ready.')
        }
    }
</script>

<style scoped>

</style>
