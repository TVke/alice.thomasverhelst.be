<template>
    <div class="absolute pin">
        <player v-for="player in players" :player="player" :active="activePlayer" :key="player.id" :paused="paused"></player>
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
                paused: true,
            }
        },
        created() {
            Event.$on('start-play', (event) => {
                this.players = event;

                setTimeout(() => {
                    this.paused = false;
                },25);


                let option = Math.floor(Math.random() * this.players.length);

                this.activePlayer = this.players[option];

                this.activePlayer = this.players[option].pawn;

                Event.$emit('active-player',this.activePlayer);
            });
        },
    }
</script>