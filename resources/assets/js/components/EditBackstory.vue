<template>
    <div class="backstory editor">
        <h1 class="ui header" v-html="title"></h1>
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
                skills: [],
                nationalities: [],
                traits: [],
                adjectives: [],
            };
        },
        mounted() {
            axios.get('/api/backstories').then((response) => {
                this.skills = response.data.skills;
                this.nationalities = response.data.nationalities;
                this.adjectives = response.data.adjectives;
                this.traits = response.data.traits;

                $('.admin.editor .dropdown').dropdown();
            })
        },
        created: function () {
            this.debouncedSubmit = _.debounce(this.submit, 500);
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
                    this.optionSelected.text = value;
                    this.debouncedSubmit();
                },
            },
            selectedId: {
                get: function () {
                    return this.optionSelected.id;
                },
                set: function (value) {
                    this.optionSelected = this.options.find((option) => {
                        return option.id === parseInt(value);
                    });
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
.backstory.editor {
    padding-bottom: 1rem;
}
</style>
