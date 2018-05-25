<template>
    <div class="flex bg-black-transparent absolute pin transition transition-delay-longer"
         :class="{'opacity-0': setupDone}">
        <div class="mx-auto mb-auto w-5/6 bg-white max-w-md rounded-b-lg p-6 pt-24 transition transition-slow shadow border border-t-0 pointer-events-auto"
             :class="{'move-up': setupDone}">
            <h2 class="p-2 font-noteworthy font-light" v-if="sessionToken === '' && allowNewPlayer">Choose your pawn</h2>
            <player-form v-if="sessionToken === '' && allowNewPlayer"
                         :options="pawnOptions"
                         @session-known="sessionToken = $event"
                         @player-added="addPlayer">
            </player-form>
            <section class="w-full p-2 py-4 block" v-if="allowNewPlayer" :class="{hidden: sessionToken === ''}">
                <h2 class="py-2 font-noteworthy font-light">Share this url</h2>
                <div class="flex">
                    <qrcode :value="sessionUrl" tag="img"></qrcode>
                    <a :href="sessionUrl" class=" block m-auto">{{ sessionUrl }}</a>
                </div>
            </section>
            <section class="w-full p-2 pt-4 block">
                <h3 class="block py-2 pb-3 font-noteworthy font-light"
                    :class="{hidden: !showCurrentPlayers}">Current players</h3>
                <ul class="block list-reset"
                    :class="{hidden: !showCurrentPlayers}">
                    <li v-for="player in players" :key="player.id">
                        - {{ player.username }} is {{ (player.pawn !== 'Alice')?'the ':'' }}
                        <strong class="text-grey-dark">{{ player.pawn }}</strong>
                    </li>
                </ul>
                <button class="block bg-alice-lighter text-base py-2 px-3 border-none rounded mt-6 mx-auto"
                        :class="{hidden: !gameCanStart}" @click.prevent="setupIsDone">
                    Start the game
                </button>
            </section>
        </div>
    </div>
</template>

<script>
    import Qrcode from '@xkeshi/vue-qrcode';
    import PlayerForm from './PlayerForm.vue';

    export default {
        name: 'GameSetup',
        components: {Qrcode, PlayerForm},
        // props: {
        //     token: {
        //         type: String,
        //         required: false,
        //     }
        // },
        data() {
            return {
                sessionToken: '',
                setupDone: false,
                players: [],
                pawnOptions: [
                    {name: 'Alice', value: 'Alice', choosen: false},
                    {name: 'Mad Hatter', value: 'Mad Hatter', choosen: false},
                    {name: 'Queen of Hearts', value: 'Queen of Hearts', choosen: false},
                    {name: 'White Rabbit', value: 'White Rabbit', choosen: false},
                ],
            }
        },
        created() {
            window.axios.get('/game/players')
                .then(({data}) => {
                    this.players = data;

                    this.parsePosition();

                    this.updateOptions(data);
                });

        },
        computed: {
            allowNewPlayer() {
                return this.players.length < 4;
            },
            gameCanStart() {
                return this.players.length >= 2;
            },
            showCurrentPlayers() {
                return this.players.length >= 1;
            },
            // sessionToken(token = ''){
            //     if (token === '' && this.token) {
            //         return '';
            //     }
            //
            //     // if (!this.token){
            //     //     return this.token;
            //     // }
            //
            //     return token
            // },
            sessionUrl(){
                if (this.sessionToken === ''){
                    return location.href;
                }

                const gameUrl = `${location.protocol}//${location.hostname}/game/${this.sessionToken}`;

                if (location.pathname.match('/game/?') && this.sessionToken !== '') {
                    location.href = gameUrl;
                }

                return gameUrl;
            },
            // gameChannel() {
            //     return window.Echo.join(`game-${this.sessionToken}`);
            // }
        },
        methods: {
            setupIsDone() {
                this.setupDone = true;

                Event.$emit('start-play', this.players);
            },
            addPlayer(data) {
                this.players.push(data);
            },
            updateOptions(data) {
                for (let player in data) {
                    const usedPawn = data[player].pawn;

                    for (let pawn in this.pawnOptions) {
                        if (usedPawn === this.pawnOptions[pawn].value) {
                            this.pawnOptions[pawn].choosen = true;
                        }
                    }
                }
            },
            parsePosition() {
                this.players.forEach((player) => {
                    player.position = JSON.parse(player.position);
                });
            }
        }
    }
</script>