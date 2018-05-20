<template>
    <div class="mx-auto max-w-md relative z--20 w-full mb-4 perspective mt-32 sm:mt-16 p-8"
         :class="{'sm:w-3/4 sm:p-0': !paused}">
        <div class="preserve3d max-w-md m-auto absolute pin z-10 block transition pointer-events-none transition-timing-ease-out transition-slow transition-delay-longest size-board"
             :class="{
             'tilt-board-sm sm:tilt-board md:tilt-board-md': !paused,
             'pawn-start-sm sm:pawn-start': paused,
             }">
            <pawn v-for="player in players" :start="position(player)" :pawn="player.pawn" :key="player.id"></pawn>
        </div>
        <div class="m-auto flex flex-wrap preserve3d tablecloth rounded transition transition-timing-ease-out transition-slow transition-delay-longest pointer-events-auto size-board"
             :class="{'paused': paused, 'sm:tilt-board tilt-board-sm md:tilt-board-md': !paused}">
            <tile v-for="(tile, index) in tiles" :tile="tile" :key="index"></tile>
            <move-maze :active="moveMazeMode" :tile="looseTile" @move-maze="moveMaze" @rotate="looseTile.rotation = $event"></move-maze>
        </div>
    </div>
</template>

<script>
    import Pawn from './Pawn.vue';
    import Tile from './Tile.vue';
    import MoveMaze from './moveMaze/MoveMaze.vue';

    export default {
        name: 'game-board',
        components: {Tile, Pawn, MoveMaze},
        data() {
            return {
                players: [],
                tiles: [],
                looseTile: {},
                activePawn: '',
                paused: true,
                moveMazeMode: false,
                movePawn: false,
            };
        },
        created() {
            axios.get('/game/tiles')
                .then(({data}) => {
                    this.looseTile = data.pop();

                    this.tiles = data;
                });

            Event.$on('start-play', (event) => {
                this.paused = false;

                this.moveMazeMode = true;

                this.players = event;
            });
        },
        methods: {
            position({pawn}) {
                let x = 0;

                if (pawn === 'Queen of Hearts' || pawn === 'White Rabbit') {
                    x = 6;
                }
                let y = 0;

                if (pawn === 'Mad Hatter' || pawn === 'Queen of Hearts') {
                    y = 6;
                }

                return {x: x, y: y};
            },
            moveMaze(event) {
                let direction = event.direction;
                let lineDirection = event.lineDirection;
                let line = event.line;
                let amount = event.amount;

                let newLooseTile, toRemove;

                this.looseTile[lineDirection] = line;
                this.looseTile[direction] = (amount > 0) ? 0 : 6;

                this.tiles.forEach((tile, index) => {
                    if (tile[lineDirection] === line) {
                        tile[direction] += amount;
                        if (tile[direction] > 6 || tile[direction] < 0) {

                            newLooseTile = tile;

                            toRemove = index;
                        }
                    }
                });

                this.tiles.splice(toRemove, 1, this.looseTile);

                this.looseTile = newLooseTile;

                this.moveMazeMode = false;
                this.movePawn = true
            },
        }
    };
</script>