<template>
    <div class="absolute pin pointer-events-none">
        <player v-for="player in players" :player="player" :active="activePlayer" :key="player.id"></player>
    </div>
</template>

<script>
    import Player from "./Player.vue";

    export default {
        name: "PlayerCards",
        components: {Player},
        data() {
            return {
                players: [],
                activePlayer: 0,
            }
        },
        created() {
            Event.$on('start-play', (event) => {
                this.players = event;

                let option = Math.floor(Math.random() * this.players.length);

                this.activePlayer = this.players[option];

                if (this.players[option].pawn === 'Alice') {
                    this.activePlayer = 1;
                }
                if (this.players[option].pawn === 'Mad Hatter') {
                    this.activePlayer = 2;
                }
                if (this.players[option].pawn === 'Queen of Hearts') {
                    this.activePlayer = 3;
                }
                if (this.players[option].pawn === 'White Rabbit') {
                    this.activePlayer = 4;
                }
            });
        },
    }
</script>