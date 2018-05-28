<template>
    <div class="absolute pin">
        <player v-for="(player, index) in players" :player="player" :active="activePlayer" :cards="objectsFor(index)" :key="player.id" :paused="paused"></player>
    </div>
</template>

<script>
import Player from './Player.vue';

export default {
    name: 'Players',
    components: { Player },
    data() {
        return {
            players: [],
            activePlayer: '',
            paused: true,
            objects: [],
        };
    },
    created() {
        window.axios.get('/game/objects').then(({ data }) => {
            this.objects = this.shuffle(data);
        });

        Event.$on('start-play', event => {
            this.players = event;

            setTimeout(() => {
                this.paused = false;
            }, 25);

            const option = Math.floor(Math.random() * event.length);

            this.activePlayer = this.players[option];

            this.activePlayer = this.players[option].pawn;

            Event.$emit('active-player', this.activePlayer);
        });
    },
    methods: {
        objectsFor(playerIndex) {
            const amountOfCards = this.objects.length / this.players.length;

            return this.objects.slice(
                playerIndex * amountOfCards,
                playerIndex * amountOfCards + amountOfCards
            );
        },
        shuffle(array) {
            for (let i = array.length - 1; i > 0; --i) {
                const randomIndex = Math.floor(Math.random() * (i + 1));
                [array[i], array[randomIndex]] = [array[randomIndex], array[i]];
            }
            return array;
        },
    },
};
</script>
