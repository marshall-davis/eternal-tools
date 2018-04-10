<template>
    <div class="ui report modal">
        <div class="header">
            Report a Bug
        </div>
        <div class="content">
            <div>Need to report an issue with this site? Please complete the form below.</div>
            <div class="ui divider"></div>
            <div class="ui form">
                <div class="field">
                    <div class="ui selection dropdown" ref="labelDropdown">
                        <input type="hidden" name="category">
                        <i class="dropdown icon"></i>
                        <div class="default text">Select a Category.</div>
                        <div class="menu">
                            <template v-for="label in labels">
                                <div class="item" :data-value="label.id">{{ label.name}}</div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="ui fluid input">
                    <input type="text" name="title" placeholder="Brief Title">
                </div>
                <div class="field">
                    <textarea name="description" placeholder="Describe the issue or request."></textarea>
                </div>
                <div class="ui fluid icon input">
                    <input type="text" name="email" placeholder="you@email.com">
                    <i class="question circle outline email help link icon"></i>
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui cancel button">Cancel</div>
            <div class="ui approve button">Submit</div>
        </div>
        <div class="ui flowing popup email">
            Email required if you wish to receive updates on this issue.
        </div>
    </div>
</template>

<script>
    export default {
        name: "report-modal",
        data: function () {
            return {
                labels: []
            };
        },
        mounted() {
            axios.get('/api/labels').then(
                (response) => {
                    this.labels = response.data.labels;
                    $(this.$refs.labelDropdown).dropdown();
                },
                (response) => {
                    console.log('Failed fetching labels.', response);
                }
            );
        }
    }
</script>

<style scoped>

</style>
