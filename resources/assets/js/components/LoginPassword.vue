<template>
    <div>
        <h1 class="ui header">Restricted Access</h1>
        <div>
            <div>
                Please enter the passcode to access this portion of the site.
            </div>
            <div class="ui action input">
                <input type="password" v-model="password" placeholder="*******" @keyup.enter="validateCode">
                <button class="ui button" @click="validateCode">Validate</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {bus} from "../app";

    export default {
        name: "login-password",
        data: function() {
            return {
                password: '',
            };
        },
        methods: {
            validateCode: function () {
                axios.post('/login', {password: this.password}).then(
                    (response) => {
                        bus.$emit('navigate', response.data.redirectTo);
                    },
                    (response) => {
                        console.log('Failed.', response);
                    }
                );
            }
        }
    }
</script>

<style scoped>

</style>
