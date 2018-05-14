<template>
    <div class="flex bg-black-transparent absolute pin transition transition-delay-longer"
         :class="{'opacity-0': setupDone}">
        <div class="mx-auto mb-auto w-5/6 bg-white max-w-md rounded-b-lg p-6 pt-24 transition shadow border border-t-0"
             :class="{'translateY--100': setupDone}">
            <h2 class="p-2" :class="{ hidden: !allowNewPlayer }">Choose your pawn</h2>
            <form class="md:flex-wrap md:flex">
                <div class="flex-1 p-2" :class="{ hidden: !allowNewPlayer }">
                    <label class="py-2 block" for="username"
                           :class="{'text-red': usernameErrorShow}">Username</label>
                    <input v-model="username" id="username" class="block p-2 w-full border border-grey rounded text-base" required
                           :disabled="submited" :class="{'border-red': usernameErrorShow}">
                </div>
                <div class="p-2" :class="{ hidden: !allowNewPlayer }">
                    <label class="py-2 block" for="pawn"
                           :class="{'text-red': pawnErrorShow}">Your pawn</label>
                    <select v-model="pawn" class="block w-full border border-grey text-base" id="pawn" required
                            :disabled="submited" :class="{'border-red': pawnErrorShow}">
                        <option v-for="option in pawnOptions"
                                :value="option.value" :disabled="option.taken">{{ option.name }}
                        </option>
                    </select>
                </div>
                <div class="w-full p-2 block" :class="{hidden: submited || !allowNewPlayer }">
                    <p class="block p-2 bg-grey-lighter rounded mb-4 -mt-2"
                       :class="{hidden: !usernameErrorShow}">{{ usernameError }}</p>
                    <p class="block p-2 bg-grey-lighter rounded mb-4 -mt-2"
                       :class="{hidden: !pawnErrorShow}">{{ pawnError }}</p>
                    <input class="bg-alice-lighter py-2 px-3 rounded mt-2" type="submit" value="Submit choose"
                           @click.prevent="addPlayer" :disabled="submited">
                </div>
            </form>

            <section class="w-full p-2 py-4 block" :class="{hidden: sessionUrl === ''}">
                <h2 class="py-2">Share this url</h2>
                <div class="flex">
                    <qrcode :value="sessionUrl" tag="img"></qrcode>
                    <p class="m-auto">{{ sessionUrl }}</p>
                </div>
            </section>
            <section class="w-full p-2 pt-4 block">
                <h3 class="block py-2 pb-3"
                    :class="{hidden: players.length < 1}">Current players</h3>
                <ul class="block list-reset"
                    :class="{hidden: players.length < 1}">
                    <li v-for="player in players"
                        :key="player.id"> - {{ player.username }}: <strong class="text-grey-dark">{{ player.pawn }}</strong></li>
                </ul>
                <button class="block bg-alice-lighter text-base py-2 px-3 border-none rounded mt-6 mx-auto"
                        :class="{hidden: players.length < 2}" @click.prevent="setupIsDone">Start the game
                </button>
            </section>

        </div>
    </div>
</template>

<script>
    import Qrcode from '@xkeshi/vue-qrcode';

    export default {
        name: "GameSetup",
        components: {Qrcode},
        data() {
            return {
                username: '',
                pawn: '',
                usernameErrorShow: false,
                usernameError: 'The username needs to at least 2 characters. Try a different one. ',
                pawnErrorShow: false,
                pawnError: 'Please, choose a pawn. ',
                submited: false,
                pawnOptions: [
                    {name: 'Alice', value: 'Alice', taken: false},
                    {name: 'Queen of Hearts', value: 'Queen of Hearts', taken: false},
                    {name: 'Mad Hatter', value: 'Mad Hatter', taken: false},
                    {name: 'White Rabbit', value: 'White Rabbit', taken: false},
                ],
                sessionUrl: '',
                setupDone: false,
                players: [],
            }
        },
        mounted() {
            axios.get('/game/players')
                .then(({data}) => {
                    this.players = data;

                    for (let player in data) {
                        let usedPawn = '';

                        if (data.hasOwnProperty(player)) {
                            usedPawn = data[player].pawn;
                        }

                        for (let pawn in this.pawnOptions) {
                            let currentPawn = this.pawnOptions[pawn];

                            if (usedPawn === currentPawn.value) {
                                currentPawn.taken = true;
                            }
                        }
                    }
                });

        },
        computed: {
            allowNewPlayer(){
                return this.players.length !== 4;
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
                    .then(response => {
                        this.sessionUrl = response.data;

                        this.players.push({
                            id: null,
                            pawn: this.pawn,
                            username: this.username,
                        });

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
            setupIsDone(){
                this.setupDone = true;
                Event.$emit('start-play');
            }
        }
    }
</script>