<template>
    <div class="m-auto z--20 w-full perspective absolute pin flex">
        <div class="preserve3d m-auto absolute pin z-10 block transition pointer-events-none transition-timing-ease-out transition-slow transition-delay-longest size-board"
             :class="{
                 'tilt-board-sm sm:tilt-board origin-x-sm sm:origin-x': !paused,
                 'pawn-start-sm sm:pawn-start': paused,
                 'move-mode sm:move-mode md:move-mode': moveMazeMode && allowPlay,
        }">
            <pawn v-for="player in players"
                  :active="activePawn"
                  :player="player"
                  :key="player.id"
                  @pawn-move="checkMoveTo">
            </pawn>
        </div>
        <div class="m-auto flex flex-wrap preserve3d tablecloth rounded transition transition-timing-ease-out transition-slow transition-delay-longest size-board"
             :class="{
                 'tilt-board-sm sm:tilt-board origin-x-sm sm:origin-x pointer-events-auto': !paused,
                 'paused cursor-default pointer-events-none': paused,
                 'move-mode sm:move-mode md:move-mode pointer-events-auto': moveMazeMode && allowPlay,
        }">
            <tile v-for="(tile, index) in tiles"
                  :class="{'pointer-events-none': !allowPlay}"
                  :tile="tile"
                  :error="tileError"
                  :key="index"
                  :disabled="paused"
                  :tabindex="(paused || moveMazeMode || !allowPlay)?'-1':'0'"
                  @tile-click="checkMoveTo">
            </tile>
            <move-maze
                    :class="{'pointer-events-none': !allowPlay}"
                    :active="moveMazeMode  && allowPlay"
                    :tile="looseTile"
                    :playerpawn="playerpawn"
                    @move-maze="moveMaze"
                    @rotate="rotateLooseTile">
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
        props: ['token', 'playerpawn'],
        components: {Tile, Pawn, MoveMaze},
        data() {
            return {
                players: [],
                tiles: [],
                looseTile: {},
                tileError: {},
                activePawn: '',
                newObject: '',
                paused: true,
                moveMazeMode: false,
                movePawnMode: false,
                tileSound: null,
                pawnSound: null,
                objectSound: null,
                welcomeSound: null,
                rotateSound: null,
                moveSound: null,
                foundSound: null,
                waitingSound: null,
                startTimeout: null,
            };
        },
        created() {
            window.Echo.join(`game.${this.token}`)
                .here(players => {
                    this.players = this.parsePosition(players);

                    this.$emit('present-players', this.players);
                })
                .joining(player => {
                    this.$emit('add-player', this.parsePosition(player));
                })
                .leaving(playerToRemove => {
                    let playerIndex = 0;
                    let pawnOfPlayer = '';

                    this.players.forEach((player, index) => {
                        if (player.username === playerToRemove.username) {
                            playerIndex = index;
                            pawnOfPlayer = player.pawn;
                        }
                    });

                    if (this.paused) {
                        window.axios.delete(`/delete/player/${pawnOfPlayer}`);
                    }
                    this.$emit('remove-player', playerIndex);
                })
                .listen('GameStarted', ({players}) => {
                    console.log(players);

                    Event.$emit('game-started', this.parsePosition(players));

                    if (this.welcomeSound) {
                        this.welcomeSound.play();
                    }

                    if (this.playerpawn === this.activePawn) {
                        this.startTimeout = setTimeout(() => {
                            if (this.rotateSound) {
                                this.rotateSound.play();
                            }
                        }, 10000);
                    }
                })
                .listen('TileMoved', ({tiles, players}) => {
                    this.players = this.parsePosition(players);

                    this.looseTile = tiles.pop();

                    this.tiles = tiles;

                    if (this.tileSound) {
                        this.tileSound.play();

                        clearTimeout(this.startTimeout);
                    }
                })
                .listen('PawnMoved', ({path}) => {
                    this.movePawnTo(path);
                })
                .listen('ObjectFound', data => {
                    Event.$emit('object-found', data);

                    if (this.allowPlay && this.objectSound) {
                        this.objectSound.play();
                    }

                    // if (data.pawn === this.playerpawn && !this.objectSound) {
                    //     if (this.bottleSound) {
                    //         this.bottleSound.play();
                    //     }
                    //
                    //     if (this.cakeSound) {
                    //         this.cakeSound.play();
                    //     }
                    //
                    //     if (this.cardsoldiersSound) {
                    //         this.cardsoldiersSound.play();
                    //     }
                    //
                    //     if (this.clubsSound) {
                    //         this.clubsSound.play();
                    //     }
                    //
                    //     if (this.crownSound) {
                    //         this.crownSound.play();
                    //     }
                    //
                    //     if (this.diamondsSound) {
                    //         this.diamondsSound.play();
                    //     }
                    //
                    //     if (this.doorknobSound) {
                    //         this.doorknobSound.play();
                    //     }
                    //
                    //     if (this.golfbalSound) {
                    //         this.golfbalSound.play();
                    //     }
                    //
                    //     if (this.golfmalletsSound) {
                    //         this.golfmalletsSound.play();
                    //     }
                    //
                    //     if (this.hammerSound) {
                    //         this.hammerSound.play();
                    //     }
                    //
                    //     if (this.hatsSound) {
                    //         this.hatsSound.play();
                    //     }
                    //
                    //     if (this.heartsSound) {
                    //         this.heartsSound.play();
                    //     }
                    //
                    //     if (this.keySound) {
                    //         this.keySound.play();
                    //     }
                    //
                    //     if (this.mirrorSound) {
                    //         this.mirrorSound.play();
                    //     }
                    //
                    //     if (this.pocketwatchSound) {
                    //         this.pocketwatchSound.play();
                    //     }
                    //
                    //     if (this.redroseSound) {
                    //         this.redroseSound.play();
                    //     }
                    //
                    //     if (this.shoeSound) {
                    //         this.shoeSound.play();
                    //     }
                    //
                    //     if (this.singingflowerSound) {
                    //         this.singingflowerSound.play();
                    //     }
                    //
                    //     if (this.spadesSound) {
                    //         this.spadesSound.play();
                    //     }
                    //
                    //     if (this.teacupSound) {
                    //         this.teacupSound.play();
                    //     }
                    //
                    //     if (this.teapotSound) {
                    //         this.teapotSound.play();
                    //     }
                    //
                    //     if (this.treeSound) {
                    //         this.treeSound.play();
                    //     }
                    //
                    //     if (this.waterpipeSound) {
                    //         this.waterpipeSound.play();
                    //     }
                    //
                    //     if (this.whiteroseSound) {
                    //         this.whiteroseSound.play();
                    //     }
                    // }
                })
                .listen('RotateTile', () => {
                    Event.$emit('rotate');
                })
                .listen('PlayerChanged', ({pawn}) => {
                    Event.$emit('player-changed', pawn);

                    if (pawn === this.playerpawn && this.rotateSound){
                        this.rotateSound.play();
                    }
                })
                .listen('PlayerWon', data => {
                    Event.$emit('player-won', data);
                });

            window.axios.get('/game/tiles').then(({data}) => {
                this.looseTile = data.pop();

                this.tiles = data;
            });

            Event.$on('game-started', players => {
                this.paused = false;
                this.moveMazeMode = true;
                this.movePawnMode = false;

                this.players = players;
            });

            Event.$on('new-object', object => {
                this.newObject = object;
            });

            Event.$on('player-changed', pawn => {
                this.activePawn = pawn;

                this.moveMazeMode = true;
                this.movePawnMode = false;
            });

            Event.$on('rotate', () => {
                this.rotateLooseTile();
            });
        },
        mounted() {
            this.tileSound = document.getElementById('tileSound');
            this.pawnSound = document.getElementById('pawnSound');
            this.objectSound = document.getElementById('objectSound');
            this.welcomeSound = document.getElementById('welcomeSound');
            this.rotateSound = document.getElementById('rotateSound');
            this.moveSound = document.getElementById('moveSound');
            this.waitingSound = document.getElementById('timeSound');
            this.winSound = document.getElementById('winSound');
            this.looseSound = document.getElementById('looseSound');

            this.bottleSound = document.getElementById('bottleSound');
            this.cakeSound = document.getElementById('cakeSound');
            this.cardsoldiersSound = document.getElementById('cardsoldiersSound');
            this.clubsSound = document.getElementById('clubsSound');
            this.crownSound = document.getElementById('crownSound');
            this.diamondsSound = document.getElementById('diamondsSound');
            this.doorknobSound = document.getElementById('doorknobSound');
            this.golfbalSound = document.getElementById('golfbalSound');
            this.golfmalletsSound = document.getElementById('golfmalletsSound');
            this.hammerSound = document.getElementById('hammerSound');
            this.hatsSound = document.getElementById('hatsSound');
            this.heartsSound = document.getElementById('heartsSound');
            this.keySound = document.getElementById('keySound');
            this.mirrorSound = document.getElementById('mirrorSound');
            this.pocketwatchSound = document.getElementById('pocketwatchSound');
            this.redroseSound = document.getElementById('redroseSound');
            this.shoeSound = document.getElementById('shoeSound');
            this.singingflowerSound = document.getElementById('singingflowerSound');
            this.spadesSound = document.getElementById('spadesSound');
            this.teacupSound = document.getElementById('teacupSound');
            this.teapotSound = document.getElementById('teapotSound');
            this.treeSound = document.getElementById('treeSound');
            this.waterpipeSound = document.getElementById('waterpipeSound');
            this.whiteroseSound = document.getElementById('whiteroseSound');
        },
        computed: {
            activePlayerIndex() {
                let playerIndex = 0;

                this.players.forEach((player, index) => {
                    if (player.pawn === this.activePawn) {
                        playerIndex = index;
                    }
                });

                return playerIndex;
            },
            allowPlay() {
                return this.activePawn === this.playerpawn;
            },
        },
        methods: {
            parsePosition(players) {
                if (!Array.isArray(players)) {
                    players.position = JSON.parse(players.position);
                }

                if (Array.isArray(players)) {
                    players.forEach(player => {
                        player.position = JSON.parse(player.position);
                    });
                }

                return players;
            },
            rotateLooseTile() {
                let newRotation = this.looseTile.rotation + 90;

                if (newRotation === 270 + 90) {
                    newRotation = 0;
                }

                if (newRotation > 90 && this.looseTile.type === 'line') {
                    newRotation = 0;
                }

                this.looseTile.rotation = newRotation;
            },
            moveMaze(event) {
                const direction = event.direction;
                const lineDirection = event.lineDirection;
                const line = event.line;
                const amount = event.amount;

                let newLooseTile, toRemove;

                this.looseTile[lineDirection] = line;
                this.looseTile[direction] = amount > 0 ? 0 : 6;

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

                this.players.forEach(player => {
                    if (player.position[lineDirection] === line) {
                        if (player.position[direction] === 0 && amount < 0) {
                            setTimeout(() => {
                                player.position[direction] = 6;
                            }, 250);
                        }

                        if (player.position[direction] === 6 && amount > 0) {
                            setTimeout(() => {
                                player.position[direction] = 0;
                            }, 250);
                        }

                        player.position[direction] += amount;
                    }
                });

                this.moveMazeMode = false;
                this.movePawnMode = true;

                Event.$emit('maze-moved');
            },
            checkMoveTo(event) {
                this.tileError = {};

                if (!this.movePawnMode) {
                    return;
                }

                const start = this.players[this.activePlayerIndex].position;
                const end = event;

                const mainList = [];
                let found = false;
                mainList.push({x: start.x, y: start.y, step: 0});

                if (start.x === end.x && start.y === end.y) {
                    found = true;
                }

                for (let i = 0; i < mainList.length && !found; ++i) {
                    const possibleNextMoves = [];

                    if (this.isOnTheBoard(mainList[i].x + 1)) {
                        const option = {
                            x: mainList[i].x + 1,
                            y: mainList[i].y,
                            step: mainList[i].step + 1,
                        };

                        if (!this.isWallBetween(mainList[i], option)) {
                            possibleNextMoves.push(option);
                        }
                    }

                    if (this.isOnTheBoard(mainList[i].x - 1)) {
                        const option = {
                            x: mainList[i].x - 1,
                            y: mainList[i].y,
                            step: mainList[i].step + 1,
                        };

                        if (!this.isWallBetween(mainList[i], option)) {
                            possibleNextMoves.push(option);
                        }
                    }

                    if (this.isOnTheBoard(mainList[i].y + 1)) {
                        const option = {
                            x: mainList[i].x,
                            y: mainList[i].y + 1,
                            step: mainList[i].step + 1,
                        };

                        if (!this.isWallBetween(mainList[i], option)) {
                            possibleNextMoves.push(option);
                        }
                    }

                    if (this.isOnTheBoard(mainList[i].y - 1)) {
                        const option = {
                            x: mainList[i].x,
                            y: mainList[i].y - 1,
                            step: mainList[i].step + 1,
                        };

                        if (!this.isWallBetween(mainList[i], option)) {
                            possibleNextMoves.push(option);
                        }
                    }

                    const toRemove = [];

                    possibleNextMoves.forEach((possibility, index) => {
                        mainList.forEach(position => {
                            if (
                                position.x === possibility.x &&
                                position.y === possibility.y &&
                                position.step <= possibility.step
                            ) {
                                toRemove.push(index);
                            }
                        });
                    });

                    toRemove.forEach(index => {
                        possibleNextMoves.splice(index, 1);
                    });

                    possibleNextMoves.forEach(possibility => {
                        mainList.push(possibility);

                        if (possibility.x === end.x && possibility.y === end.y) {
                            found = true;
                        }
                    });
                }

                if (!found) {
                    clearTimeout(resetError);

                    this.tileError = {x: end.x, y: end.y};

                    let resetError = setTimeout(() => {
                        this.tileError = {};
                    }, 1000);

                    return;
                }

                if (found && this.objectIsAt(end.x, end.y)) {
                    window.axios
                        .post('/found/object', {object: this.newObject.name, pawn: this.playerpawn})
                        .then(({data}) => {
                            Event.$emit('new-object', data);
                        });
                }

                mainList.reverse();

                const cleanPath = [];
                const endStep = mainList.filter(item => {
                    if (item.x === end.x && item.y === end.y) {
                        return item;
                    }
                })[0];

                cleanPath.push(endStep);

                mainList.forEach(item => {
                    const lastItem = cleanPath[cleanPath.length - 1];
                    if (
                        lastItem.step - 1 === item.step &&
                        !this.isWallBetween(lastItem, item) &&
                        (lastItem.x === item.x || lastItem.y === item.y) &&
                        (Math.abs(lastItem.x - item.x) === 1 || Math.abs(lastItem.y - item.y) === 1)
                    ) {
                        cleanPath.push(item);
                    }
                });

                if (cleanPath.length > 1) {
                    window.axios.patch(`/update/player/${this.activePawn}`, {path: cleanPath});

                    Event.$emit('pawn-moving');

                    this.movePawnTo(cleanPath);
                }
            },
            movePawnTo(path) {
                const pathToMove = path;

                if (path.length > 1) {
                    const move = setInterval(() => {
                        if (pathToMove.length <= 1) {
                            clearInterval(move);

                            Event.$emit('player-may-change');
                        }

                        const moveTo = pathToMove.pop();

                        const activePlayer = this.players[this.activePlayerIndex];

                        const newPlayer = {
                            id: activePlayer.id,
                            name: activePlayer.name,
                            username: activePlayer.username,
                            pawn: activePlayer.pawn,
                            position: {x: moveTo.x, y: moveTo.y},
                        };

                        this.players.splice(this.activePlayerIndex, 1, newPlayer);

                        if (this.pawnSound) {
                            this.pawnSound.play();
                        }
                    }, 250);
                }

                const moveTo = pathToMove.pop();

                const activePlayer = this.players[this.activePlayerIndex];

                const newPlayer = {
                    id: activePlayer.id,
                    name: activePlayer.name,
                    username: activePlayer.username,
                    pawn: activePlayer.pawn,
                    position: {x: moveTo.x, y: moveTo.y},
                };

                this.players.splice(this.activePlayerIndex, 1, newPlayer);
            },
            isOnTheBoard(position) {
                return position >= 0 && position < 7;
            },
            isWallBetween(positionOne, positionTwo) {
                const tileOne = this.getTileobject(positionOne.x, positionOne.y);
                const tileTwo = this.getTileobject(positionTwo.x, positionTwo.y);

                const direction = this.getDirection(positionOne, positionTwo);

                const tileOneWalls = this.getWalls(tileOne);
                const tileTwoWalls = this.getWalls(tileTwo);

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
            getTileobject(x, y) {
                let tileObject = {};

                this.tiles.forEach(tile => {
                    if (tile.x === x && tile.y === y) {
                        tileObject = tile;
                    }
                });

                return tileObject;
            },
            objectIsAt(x, y) {
                const object = this.getTileobject(x, y).object;

                return object && object.name === this.newObject.name;
            },
            getDirection(positionOne, positionTwo) {
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
            getWalls(tile) {
                let walls = {
                    top: false,
                    right: false,
                    bottom: false,
                    left: false,
                };

                if (tile.type === 'line') {
                    if (tile.rotation === 0 || tile.rotation === 180) {
                        walls.top = true;
                        walls.bottom = true;
                    }

                    if (tile.rotation === 90 || tile.rotation === 270) {
                        walls.left = true;
                        walls.right = true;
                    }
                }

                if (tile.type === 'corner') {
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

                if (tile.type === 'tpoint') {
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
            },
        },
    };
</script>
