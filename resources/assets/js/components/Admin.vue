<template>
    <div class="admin editor">
        <edit-backstory attribute="trait" :options="traits"></edit-backstory>
    </div>
</template>

<script>
    export default {
        name: "admin",
        components: {
            'edit-backstory': Vue.component('edit-backstory', function (resolve) {require(['./EditBackstory'], resolve);}),
        },
        data: () => {
            return {
                skills: [],
                nationalities: [],
                traits: [],
                adjectives: [],
                adjective: {
                    id: undefined,
                    text: '',
                },
            }
        },
        methods: {
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
    }
</script>

<style scoped>

</style>
