<template>
    <div class="backstory editor">
        <h1 class="ui header" v-html="title"></h1>
        <div ref="dropdown" class="ui search selection fluid dropdown">
            <input type="hidden" @change="select" name="adjective">
            <i class="dropdown icon"></i>
            <div class="menu">
                <template v-for="item in options">
                    <div class="item" :data-value="item.id">{{ item.text }}</div>
                </template>
            </div>
        </div>
        <div>
            <div class="ui fluid action input">
                <input type="text" v-model="selectedText" :title="attribute">
                <div :class="deleteButtonClass">Delete</div>
                <div :class="saveButtonClass" @click="save">Save</div>
            </div>
            <div>
                <transition name="fade">
                    <i :class="icon" v-if="showIcon"></i>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditBackstory",
        props: [
            'attribute',
        ],
        data: () => {
            return {
                optionSelected: {
                    id: null,
                    text: '',
                },
                options: [],
                icon: '',
                showIcon: false,
            };
        },
        mounted() {
            this.updateOptions();
        },
        created: function () {
            this.basUrl =
        },
        computed: {
            title: function () {
                return _.capitalize(this.attribute);
            },
            selectedText: {
                get: function () {
                    return this.optionSelected.text;
                },
                set: function (value) {
                    this.showIcon = false;
                    this.optionSelected.text = value;
                },
            },
            selectedId: {
                get: function () {
                    return this.optionSelected.id;
                },
                set: function (value) {
                    this.showIcon = false;
                    this.optionSelected = this.options.find((option) => {
                        return option.id === parseInt(value);
                    });
                },
            },
            deleteButtonClass: function () {
                let buttonClasses = [
                    'ui',
                    'red',
                    'button',
                ];
                if (!this.selectedId) {
                    buttonClasses.push('disabled');
                }

                return buttonClasses.join(' ');
            },
            saveButtonClass: function () {
                let buttonClasses = [
                    'ui',
                    'green',
                    'button',
                ];
                if (this.selectedText === '') {
                    buttonClasses.push('disabled');
                }

                return buttonClasses.join(' ');
            },
            baseUrl: function () {
                return '/api/backstories/' + this.attribute + '/';
            }
        },
        methods: {
            displayIcon: function () {
                this.showIcon = true;
                setTimeout(() => {
                    this.showIcon = false;
                }, 1000);
            },
            save: function () {
                let axiosPromise = undefined;

                if (this.optionSelected.id) {
                    axiosPromise = this.update();
                } else {
                    axiosPromise = this.save();
                }

                axiosPromise.then(() => {
                    this.icon = 'green check circle outline icon';
                    this.updateOptions();
                }).catch(() => {
                    this.icon = 'red ban icon'
                }).then(() => {
                    this.displayIcon();
                });
            },
            update: function () {
                url = this.baseUrl + this.optionSelected.id;

                return axios.put(url, {
                    text: this.optionSelected.text,
                })
            },
            create: function () {
                return axios.post(this.baseUrl, {
                    text: this.optionSelected.text,
                })
            },
            delete: function () {
                if (this.optionSelected.id) {
                    let url = '/api/backstories/' + this.attribute + '/' + this.optionSelected.id;
                    axios.delete(url)
                        .then(() => {
                            this.icon = 'green check circle outline icon';
                            this.updateOptions();
                        })
                        .catch(() => {
                            this.icon = 'red ban icon'
                        })
                        .then(() => {
                            this.displayIcon();
                        });
                }
            },
            select: function (event) {
                this.selectedId = event.currentTarget.value;
            },
            updateOptions: function () {
                axios.get('/api/backstories/' + this.attribute).then((response) => {
                    this.options = response.data.options;

                    $(this.$refs.dropdown).dropdown();
                })
            },
        },
    }
</script>

<style scoped>
    .backstory.editor {
        padding-bottom: 1rem;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.25s ease-out;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
