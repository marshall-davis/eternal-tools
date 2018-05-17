<template>
    <div class="admin editor">
        <edit-backstory attribute="trait"></edit-backstory>
        <edit-backstory attribute="skill"></edit-backstory>
        <edit-backstory attribute="adjective"></edit-backstory>
        <edit-backstory attribute="nationality"></edit-backstory>
    </div>
</template>

<script>
    export default {
        name: "admin",
        components: {
            'edit-backstory': Vue.component('edit-backstory', function (resolve) {require(['./Characters/EditBackstory'], resolve);}),
        }
    }
</script>

<style scoped>

</style>
