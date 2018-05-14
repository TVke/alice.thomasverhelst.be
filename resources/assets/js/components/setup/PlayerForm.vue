<template>
    <form class="md:flex-wrap md:flex">
        <div class="flex-1 p-2">
            <label class="py-2 block" for="username" :class="{'text-red': usernameErrorShow}">Username</label>
            <input v-model="username" required id="username" :disabled="submited"
                   class="block p-2 w-full border border-grey rounded text-base"
                   :class="{'border-red': usernameErrorShow}" @keydown="usernameErrorShow = false">
        </div>
        <div class="p-2">
            <label class="py-2 block" for="pawn" :class="{'text-red': pawnErrorShow}">Your pawn</label>
            <select v-model="pawn" class="block w-full border border-grey text-base" id="pawn" required
                    :disabled="submited" :class="{'border-red': pawnErrorShow}" @change="pawnErrorShow = false">
                <option v-for="option in options" :value="option.value" :disabled="option.choosen">
                    {{ option.name }}
                </option>
            </select>
        </div>
        <div class="w-full p-2 block" :class="{hidden: submited}">
            <p class="block p-2 bg-grey-lighter rounded mb-4 -mt-2" :class="{hidden: !usernameErrorShow}">
                {{ usernameError }}
            </p>
            <p class="block p-2 bg-grey-lighter rounded mb-4 -mt-2" :class="{hidden: !pawnErrorShow}">
                {{ pawnError }}
            </p>
            <input class="bg-alice-lighter py-2 px-3 rounded mt-2" type="submit" value="Submit choose"
                   :disabled="submited" @click.prevent="addPlayer">
        </div>
    </form>
</template>

<script>
    export default {
        name: "PlayerForm",
        props: ['options'],
        data() {
            return {
                username: '',
                pawn: '',
                usernameErrorShow: false,
                usernameError: 'The username needs to at least 2 characters. Try a different one. ',
                pawnErrorShow: false,
                pawnError: 'Please, choose a pawn. ',
                submited: false,
            }
        },
        methods: {
            addPlayer() {
                this.pawnErrorShow = false;
                this.usernameErrorShow = false;

                if (this.username.length < 2) {
                    this.usernameErrorShow = true;

                    return;
                }

                axios.put('/add/player/', {username: this.username, pawn: this.pawn})
                    .then(({data}) => {
                        this.$emit('session-known', data);

                        this.$emit('player-added', {id: null, pawn: this.pawn, username: this.username});

                        this.submited = true;
                    })
                    .catch(({response}) => {
                        this.submited = false;

                        let errors = response.data.errors;

                        if (errors.username) {
                            this.usernameError = errors.username[0];
                            this.usernameErrorShow = true;
                        }

                        if (errors.pawn) {
                            this.pawnError = errors.pawn[0];
                            this.pawnErrorShow = true;
                        }
                    });
            },
        }
    }
</script>