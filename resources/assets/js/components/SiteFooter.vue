<template>
    <div class="main-footer">
        <div>
            <a href="http://www.skotos.net/games/eternal-city/" title="The Eternal City Game">The Eternal City</a> is
            copyright Worlds Apart Productions LLC & Skotos Tech. Inc.
        </div>
        <div>
            <em>Eternal City Tools</em> is not affiliated with Worlds Apart Productions LLC, Skotos Tech Inc. or The Eternal City.
        </div>
        <div>
            Want to help <em>Eternal City Tools</em>? <a href="" v-on:click.stop.prevent="donate">Donate</a> for server costs or submit a
            pull request on <a href="https://github.com/ToothlessRebel/eternal-tools"><i class="github icon"></i></a>.
        </div>

        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" ref="donationForm">
            <input type="hidden" name="cmd" value="_donations">
            <input type="hidden" name="business" value="4CGK7824JJXN8">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="item_name" value="Exposure Software">
            <input type="hidden" name="item_number" value="Eternal Tools">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHosted">
        </form>
    </div>
</template>

<script>
    export default {
        name: "site-footer",
        methods: {
            donate: function () {
                console.log('Donating!');
                $(this.$refs.donationForm).submit();
            },
        },
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

    .main-footer .github.icon {
        margin: 0;
    }
</style>
