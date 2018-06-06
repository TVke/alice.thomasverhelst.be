<template>
    <div class="absolute pin">
        <player v-for="player in players"
                :player="player"
                :current="{pawn: playerpawn, object: object}"
                :objects="cardsOfPlayer(player)"
                :active="activePlayer"
                :paused="paused"
                :key="player.username"></player>
    </div>
</template>

<script>
import Player from './Player.vue';

export default {
    name: 'Players',
    components: { Player },
    props: ['object', 'playerpawn'],
    data() {
        return {
            players: [],
            activePlayer: '',
            paused: true,
            objectsCount: [],
        };
    },
    created: function() {
        Event.$on('game-started', players => {
            setTimeout(() => {
                this.paused = false;
            }, 25);

            this.players = players;

            let cardsToUse = Math.round(24 / this.players.length);

            this.players.forEach(({ pawn }) => {
                let objects = cardsToUse;

                if (pawn === this.playerpawn) {
                    --objects;
                }

                this.objectsCount.push({ pawn: pawn, objects: objects });
            });
        });

        Event.$on('player-changed', ({ pawn }) => {
            this.activePlayer = pawn;
        });
    },
    methods: {
        cardsOfPlayer({ pawn }) {
            let cards = 0;

            this.objectsCount.forEach(player => {
                if (pawn === player.pawn) {
                    cards = player.objects;
                }
            });

            return cards;
        },
    },
};
</script>
