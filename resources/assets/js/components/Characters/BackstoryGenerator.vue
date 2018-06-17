<template>
    <div class="character generator">
        <div v-if="!character">
            Loading...
        </div>
        <div v-else>
            <div>{{ character }}</div>
            <button @click="buildCharacter" class="ui basic clickable button">I don't like that one, gimme another.</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "backstory-generator",
        data: () => {
            return {
                skills: [],
                nationalities: [],
                traits: [],
                adjectives: [],
                character: ''
            }
        },
        methods: {
            buildCharacter: function () {
                let first_adjective = this.pickRandom(this.adjectives) + ',';
                this.character = [
                    'You should play',
                    this.isVowel(first_adjective.substr(0, 1)) ? 'an' : 'a',
                    first_adjective,
                    this.pickRandom(this.adjectives),
                    this.pickRandom(this.nationalities),
                    this.pickRandom(this.skills),
                    'who',
                    this.pickRandom(this.traits),
                    'and',
                    this.pickRandom(this.traits)
                ].join(' ') + '.';
            },
            pickRandom: function (items) {
                return items[Math.floor(Math.random() * items.length)].text;
            },
            isVowel: function (letter) {
                letter = letter.toLowerCase();
                return letter === "a" || letter === "e" || letter === "i" || letter === "o" || letter === "u";
            }
        },
        mounted() {
            axios.get('/api/backstories').then((response) => {
                this.skills = response.data.skills;
                this.nationalities = response.data.nationalities;
                this.adjectives = response.data.adjectives;
                this.traits = response.data.traits;

                this.buildCharacter();
            })
        }
    }
</script>

<style scoped>
    .character.generator {
        min-height: 500px;
    }

    .button {
        margin-top: 1rem;
    }
</style>
