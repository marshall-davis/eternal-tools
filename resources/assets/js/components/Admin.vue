<template>
    <div class="admin editor">
        <edit-backstory attribute="trait" :options="traits"></edit-backstory>
        <edit-backstory attribute="skill" :options="skills"></edit-backstory>
        <edit-backstory attribute="adjective" :options="adjectives"></edit-backstory>
        <edit-backstory attribute="nationality" :options="nationalities"></edit-backstory>
    </div>
</template>

<script>
    export default {
        name: "admin",
        components: {
            'edit-backstory': Vue.component('edit-backstory', function (resolve) {require(['./EditBackstory'], resolve);}),
        }
    }
</script>

<style scoped>

</style>
