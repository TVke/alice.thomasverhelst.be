<template>
    <div class="absolute pin">
        <player v-for="player in players" :player="player" :active="activePlayer" :key="player.id"></player>
    </div>
</template>

<script>
    import Player from './Player.vue';

    export default {
        name: 'Players',
        components: {Player},
        data() {
            return {
                players: [],
                activePlayer: '',
            }
        },
        created() {
            Event.$on('start-play', (event) => {
                this.players = event;

                let option = Math.floor(Math.random() * this.players.length);

                this.activePlayer = this.players[option];

                this.activePlayer = this.players[option].pawn;

                Event.$emit('active-player',this.activePlayer);
            });
        },
    }
</script>