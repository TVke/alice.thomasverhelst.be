<template>
    <div class="mx-auto max-w-md relative z--20 w-full mb-4 perspective p-8"
         :class="{'sm:w-3/4 sm:p-0': !paused}">
        <div class="preserve3d max-w-md mx-auto absolute pin z-10 block pointer-events-none transition p-8"
             :class="{'sm:rotateX-50 sm:translateX--20 sm:p-0': !paused}">
            <pawn v-for="player in players" :name="player.pawn" :key="player.username"></pawn>
        </div>
        <div class="flex flex-wrap preserve3d tablecloth rounded transition p-1"
             :class="{'sm:rotateX-50 sm:translateX--20 sm:shadow': !paused}">
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
        mounted() {
            axios.get('/game/tiles')
                .then(({data}) => {
                    this.tiles = data
                });

            Event.$on('start-play', () => {
                this.paused = false;
            })
        },
    };
</script>