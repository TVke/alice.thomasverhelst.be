<template>
    <div class="mx-auto max-w-md relative z--20 w-full mb-4 perspective mt-32 sm:mt-16 p-8"
         :class="{'sm:w-3/4 sm:p-0': !paused}">
        <div class="preserve3d max-w-md m-auto absolute pin z-10 block transition pointer-events-none transition-timing-ease-out transition-slow transition-delay-longest size-board"
             :class="{
             'tilt-board-sm sm:tilt-board md:tilt-board-md': !paused,
             'pawn-start-sm sm:pawn-start': paused,
             }">
            <pawn v-for="player in players"
                  :active="activePawn"
                  :player="player"
                  :key="player.id">
            </pawn>
        </div>
        <div class="m-auto flex flex-wrap preserve3d tablecloth rounded transition transition-timing-ease-out transition-slow transition-delay-longest pointer-events-auto size-board"
             :class="{'paused': paused, 'sm:tilt-board tilt-board-sm md:tilt-board-md': !paused}">
            <tile v-for="(tile, index) in tiles"
                  :tile="tile"
                  :error="tileError"
                  :key="index"
                  @tile-click="checkMoveTo">
            </tile>
            <move-maze
                    :active="moveMazeMode"
                    :tile="looseTile"
                    @move-maze="moveMaze"
                    @rotate="looseTile.rotation = $event">
            </move-maze>
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
                tileError: {},
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

                for (let i = 0, ilen = this.players.length; i < ilen; ++i) {
                    this.players[i] = Object.assign({}, this.players[i], {
                        position: this.position(this.players[i]),
                    });
                }
            });

            Event.$on('active-player', (event) => {
                this.activePawn = event;
            });
        },
        computed: {
            activePawnPosition() {
                let position = {};

                this.players.forEach((player) => {
                    if (player.pawn === this.activePawn) {
                        position = player.position;
                    }
                });

                return position;
            }
        },
        methods: {
            position({pawn}) {
                let x = 0;
                let y = 0;

                if (pawn === 'Queen of Hearts' || pawn === 'White Rabbit') {
                    x = 6;
                }

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
            checkMoveTo(event) {
                this.tileError = {};

                const start = this.activePawnPosition;
                const end = event;

                let mainList = [];
                let found = false;
                mainList.push({x: start.x, y: start.y, step: 0});

                if (start.x === end.x && start.y === end.y){
                    found = true;
                }

                for (let i = 0; i < mainList.length && !found; ++i) {
                    let possibleNextMoves = [];

                    if (this.isOnTheBoard(mainList[i].x + 1)) {
                        let option = {x: mainList[i].x + 1, y: mainList[i].y, step: mainList[i].step + 1};
                        if (!this.isWallBetween(mainList[i], option)) {
                            possibleNextMoves.push(option);
                        }
                    }

                    if (this.isOnTheBoard(mainList[i].x - 1)) {
                        let option = {x: mainList[i].x - 1, y: mainList[i].y, step: mainList[i].step + 1};
                        if (!this.isWallBetween(mainList[i], option)) {
                            possibleNextMoves.push(option);
                        }
                    }

                    if (this.isOnTheBoard(mainList[i].y + 1)) {
                        let option = {x: mainList[i].x, y: mainList[i].y + 1, step: mainList[i].step + 1};
                        if (!this.isWallBetween(mainList[i], option)) {
                            possibleNextMoves.push(option);
                        }
                    }

                    if (this.isOnTheBoard(mainList[i].y - 1)) {
                        let option = {x: mainList[i].x, y: mainList[i].y - 1, step: mainList[i].step + 1};
                        if (!this.isWallBetween(mainList[i], option)) {
                            possibleNextMoves.push(option);
                        }
                    }

                    let toRemove = [];

                    possibleNextMoves.forEach((possibility, index) => {
                        mainList.forEach((position) => {
                            if (position.x === possibility.x &&
                                position.y === possibility.y &&
                                position.step <= possibility.step) {
                                toRemove.push(index);
                            }
                        });
                    });

                    toRemove.forEach((index) => {
                        possibleNextMoves.splice(index, 1);
                    });

                    possibleNextMoves.forEach((possibility) => {
                        mainList.push(possibility);

                        if (possibility.x === end.x && possibility.y === end.y){
                            found = true;
                        }
                    });
                }

                if (!found){
                    this.tileError = {x: end.x, y: end.y};

                    return;
                }

                mainList.reverse();

                let  endStep = mainList.filter((item) => {
                    if (item.x === end.x && item.y === end.y) {
                        return item.step;
                    }
                })[0];

                console.log(mainList);
                console.log(endStep);
            },
            isOnTheBoard(position) {
                return position >= 0 && position < 7;
            },
            isWallBetween(positionOne, positionTwo){
                let tileOne = this.getTileobject(positionOne.x, positionOne.y);
                let tileTwo = this.getTileobject(positionTwo.x, positionTwo.y);

                let direction = this.getDirection(positionOne, positionTwo);

                let tileOneWalls = this.getWalls(tileOne);
                let tileTwoWalls = this.getWalls(tileTwo);

                if (direction === 'down') {
                    return tileOneWalls.bottom || tileTwoWalls.top;
                }

                if (direction === 'up') {
                    return tileOneWalls.top || tileTwoWalls.bottom;
                }

                if (direction === 'left') {
                    return tileOneWalls.right || tileTwoWalls.left;
                }

                if (direction === 'right') {
                    return tileOneWalls.left || tileTwoWalls.right;
                }

                return false;
            },
            getTileobject(x,y){
                let tileObject = {};

                this.tiles.forEach((tile)=>{
                    if (tile.x === x && tile.y === y) {
                        tileObject = tile;
                    }
                });

                return tileObject;
            },
            getDirection(positionOne, positionTwo){
                if (positionOne.x === positionTwo.x) {
                    if (positionOne.y < positionTwo.y) {
                        return 'down';
                    }

                    if (positionOne.y > positionTwo.y) {
                        return 'up';
                    }
                }
                if (positionOne.y === positionTwo.y) {
                    if (positionOne.x < positionTwo.x) {
                        return 'left';
                    }

                    if (positionOne.x > positionTwo.x) {
                        return 'right';
                    }
                }
            },
            getWalls(tile){
                let walls = {
                    top: false,
                    right: false,
                    bottom: false,
                    left: false,
                };

                if (tile.type.name === 'line') {
                    if (tile.rotation === 0 || tile.rotation === 180) {
                        walls.top = true;
                        walls.bottom = true;
                    }

                    if (tile.rotation === 90 || tile.rotation === 270) {
                        walls.left = true;
                        walls.right = true;
                    }
                }

                if (tile.type.name === 'corner') {
                    if (tile.rotation === 0) {
                        walls.top = true;
                        walls.right = true;
                    }
                    if (tile.rotation === 90) {
                        walls.right = true;
                        walls.bottom = true;
                    }
                    if (tile.rotation === 180) {
                        walls.bottom = true;
                        walls.left = true;
                    }
                    if (tile.rotation === 270) {
                        walls.left = true;
                        walls.top = true;
                    }
                }

                if (tile.type.name === 'tpoint') {
                    if (tile.rotation === 0) {
                        walls.bottom = true;
                    }
                    if (tile.rotation === 90) {
                        walls.left = true;
                    }
                    if (tile.rotation === 180) {
                        walls.top = true;
                    }
                    if (tile.rotation === 270) {
                        walls.right = true;
                    }
                }

                return walls;
            }
        }
    };
</script>