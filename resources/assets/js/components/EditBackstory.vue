<template>
    <div>
        <h1 class="ui header" :html="attribute"></h1>
        <div class="ui search selection fluid dropdown">
            <input type="hidden" @change="select" name="adjective">
            <i class="dropdown icon"></i>
            <div class="menu">
                <template v-for="item in options">
                    <div class="item" :data-value="item.id">{{ item.text }}</div>
                </template>
            </div>
        </div>
        <div class="ui fluid input">
            <input type="text" v-model="selectedText" :title="attribute">
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditBackstory",
        props: [
            'attribute',
            'options',
        ],
        data: () => {
            return {
                optionSelected: {
                    id: undefined,
                    text: '',
                },
            };
        },
        created: function () {
            this.debouncedSubmit = _.debounce(this.submit, 500);
        },
        computed: {
            selectedText: {
                get: function () {
                    return this.optionSelected.text;
                },
                set: function (value) {
                    this.optionSelected.text = value;
                    this.debouncedSubmit();
                },
            },
            selectedId: {
                get: function () {
                    return this.optionSelected.id;
                },
                set: function (value) {
                    this.optionSelected = this.options[value];
                },
            },
        },
        methods: {
            submit: function () {
                console.log('Submitting changes', this.optionSelected);
            },
            select: function (event) {
                this.selectedId = event.currentTarget.value;
            },
        },
    }
</script>

<style scoped>

</style>
