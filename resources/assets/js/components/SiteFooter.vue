<template>
    <div class="main-footer">
        <div><a href="http://www.skotos.net/games/eternal-city/" title="The Eternal City Game">The Eternal City</a> is copyright Worlds Apart Productions LLC & Skotos Tech. Inc.</div>
        <div>Want to help out? Donate for server costs.</div>
    </div>
</template>

<script>
    export default {
        name: "site-footer"
    }
</script>

<style scoped>
    .main-footer {
        text-align: center;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        pointer-events: none;
        padding-top: 3rem;
    }

    .main-footer a {
        pointer-events: auto;
    }
</style>
