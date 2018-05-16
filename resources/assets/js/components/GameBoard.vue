<template>
    <div class="mx-auto max-w-md relative z--20 w-full mb-4 perspective mt-32 sm:mt-16 p-8"
         :class="{'sm:w-3/4 sm:p-0': !paused}">
        <div class="preserve3d max-w-md m-auto absolute pin z-10 block transition pointer-events-none transition-timing-ease-out transition-slow transition-delay-longest size-board"
             :class="{'sm:tilt-board tilt-board-sm md:tilt-board-md': !paused}">
            <pawn v-for="player in players" :player="player" :key="player.id"></pawn>
        </div>
        <div class="m-auto flex flex-wrap preserve3d tablecloth rounded transition transition-timing-ease-out transition-slow transition-delay-longest pointer-events-auto size-board"
             :class="{'sm:tilt-board tilt-board-sm sm:shadow md:tilt-board-md': !paused}">
            <tile v-for="tile in tiles" :tile="tile" :key="tile.name"></tile>
        </div>
    </div>
</template>

<script>
    import Pawn from "./Pawn.vue";
    import Tile from "./Tile.vue";

    export default {
        components: {Tile, Pawn},
        name: 'game-board',
        data() {
            return {
                players: [],
                tiles: [],
                paused: true,
            };
        },
        created() {
            axios.get('/game/tiles')
                .then(({data}) => {
                    this.tiles = data
                });

            Event.$on('start-play', (event) => {
                this.paused = false;

                this.players = event;
            });
        },
    };
</script>