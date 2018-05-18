<template>
    <div class="mx-auto max-w-md relative z--20 w-full mb-4 perspective mt-32 sm:mt-16 p-8"
         :class="{'sm:w-3/4 sm:p-0': !paused}">
        <div class="preserve3d max-w-md m-auto absolute pin z-10 block transition pointer-events-none transition-timing-ease-out transition-slow transition-delay-longest size-board"
             :class="{'sm:tilt-board tilt-board-sm md:tilt-board-md': !paused}">
            <pawn v-for="player in players" :start="position(player)" :pawn="player.pawn" :key="player.id"></pawn>
        </div>
        <div class="m-auto flex flex-wrap preserve3d tablecloth rounded transition transition-timing-ease-out transition-slow transition-delay-longest pointer-events-auto size-board"
             :class="{'sm:tilt-board tilt-board-sm sm:shadow md:tilt-board-md': !paused}">
            <tile v-for="(tile, index) in tiles" :tile="tile" :key="index"></tile>
            <div>
                <ghost-tile v-for="leftTile in 7" :x="-1" :y="leftTile - 1" :tile="looseTile" :key="leftTile"
                @add-tile="addTile">
                </ghost-tile>
                <ghost-tile v-for="topTile in 7" :x="topTile - 1" :y="-1" :tile="looseTile" :key="topTile + 7"
                @add-tile="addTile">
                </ghost-tile>
                <ghost-tile v-for="rightTile in 7" :x="7" :y="rightTile - 1" :tile="looseTile" :key="rightTile + 14"
                @add-tile="addTile">
                </ghost-tile>
                <ghost-tile v-for="bottomTile in 7" :x="bottomTile - 1" :y="7" :tile="looseTile" :key="bottomTile + 21"
                @add-tile="addTile">
                </ghost-tile>
            </div>
        </div>
    </div>
</template>

<script>
    import Pawn from "./Pawn.vue";
    import Tile from "./Tile.vue";
    import GhostTile from "./GhostTile.vue";

    export default {
        components: {Tile, Pawn, GhostTile},
        name: 'game-board',
        data() {
            return {
                players: [],
                tiles: [],
                looseTile: {},
                paused: true,
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

                this.players = event;
            });
        },
        methods: {
            position({pawn}) {
                let x = 0;

                if (pawn === 'Queen of Hearts' || pawn === 'Mad Hatter') {
                    x = 6;
                }
                let y = 0;

                if (pawn === 'White Rabbit' || pawn === 'Queen of Hearts') {
                    y = 6;
                }

                return {x: x, y: y};
            },
            addTile(position){
                let x = position.x;
                let y = position.y;

                if (x === -1) {
                    this.moveRow(y, 1);
                }
                if (y === -1) {
                    this.moveColumn(x, 1);
                }
                if (x === 7) {
                    this.moveRow(y, -1);
                }
                if (y === 7) {
                    this.moveColumn(x, -1);
                }
            },
            moveRow(row, amount) {

            },
            moveColumn(column, amount) {

            },
        }
    };
</script>