"use strict";

// !function(window, undefined) {
//
// }(window);

var Observable = function Observable() {
    var _self = this;
    _self.data;
    _self.subs = [];
    _self.methods = {
        publish: function publish(newData) {
            if (typeof newData !== 'undefined') {
                _self.data = newData;
                for (var i = 0, ilen = _self.subs.length; i < ilen; ++i) {
                    _self.subs[i](_self.data);
                }
            } else {
                return _self.data;
            }
        },
        subscribe: function subscribe(callback) {
            if (_self.subs.indexOf(callback) === -1) {
                _self.subs.push(callback);
            }
        },
        unsubscribe: function unsubscribe(callback) {
            if (_self.subs.indexOf(callback) !== -1) {
                _self.subs.splice(_self.subs.indexOf(callback), 1);
            }
        }
    };
    return _self.methods;
};

var view = {
    game_field: document.getElementsByClassName("game")[0],
    pawns: document.querySelectorAll(".pawns>[id^=pawn-]"),
    tiles: document.getElementsByClassName("tile")
};

var model = {
    field_size: new Observable(),
    tiles: [],
    pawns: [],
    tileLocation: new Observable(),
    tileType: new Observable(),
    animationSpeedInSeconds: new Observable(),
    activePlayer: new Observable(),
    mover: new Observable()
};
var GameController = {
    initial: function initial() {
        GameFieldController.initial();
        EventController.initial();
        model.animationSpeedInSeconds.publish(.25);
        model.activePlayer.publish(0);
    }
};
var GameFieldController = {
    initial: function initial() {
        viewController.setTileAssetLink();
        this.setupTileModels();
        this.setupPawnModels();
    },
    setupTileModels: function setupTileModels() {
        model.field_size.publish(parseInt(view.game_field.dataset.field_size));
        var i = 0;
        for (var y = 0; y < model.field_size.publish(); ++y) {
            var tileRow = [];

            var _loop = function _loop(x) {
                var newTile = new Observable();
                newTile.publish({
                    x: x,
                    y: y,
                    type: view.tiles[i].dataset.tileType,
                    rotation: parseInt(view.tiles[i].dataset.tileRotation)
                });
                !function (i) {
                    newTile.subscribe(function (data) {
                        var tile = view.tiles[i];
                        var tileImage = tile.getElementsByTagName("img")[0];

                        if (!tile.classList.contains("place-" + data.x + "-" + data.y)) {
                            viewController.clearClass(tile, "place");
                            tile.classList.add("place-" + data.x + "-" + data.y);
                        }
                        if (!tileImage.classList.contains("rotate-" + data.rotation)) {
                            viewController.clearClass(tileImage, "rotate");
                            tileImage.classList.add("rotate-" + data.rotation);
                        }
                        if (tileImage.src !== model.tileLocation.publish() + data.type + "." + model.tileType.publish()) {
                            tileImage.src = model.tileLocation.publish() + data.type + "." + model.tileType.publish();
                        }

                        // warnings and errors
                        if (data.x >= model.field_size.publish() + 1) {
                            console.warn("the x value(" + data.x + ") is to large and the tile will appear as floating in the air");
                        }
                        if (data.y >= model.field_size.publish() + 1) {
                            console.warn("the y value(" + data.y + ") is to large and the tile will appear as floating in the air");
                        }
                        if (data.x < -1) {
                            console.warn("the x value(" + data.x + ") is to small and the style will reset to 0");
                        }
                        if (data.y < -1) {
                            console.warn("the y value(" + data.y + ") is to small and the style will reset to 0");
                        }
                        if (data.rotation !== 0 && data.rotation !== 90 && data.rotation !== 180 && data.rotation !== 270) {
                            console.warn("the rotation value(" + data.rotation + ") is not in the range of options and the style will reset to 0");
                        }
                        if (data.type !== "corner" && data.type !== "tpoint" && data.type !== "line") {
                            console.error("the tile type value(" + data.type + ") is not in the range of options and it will disappear!");
                        }
                    });
                }(i);
                tileRow.push(newTile);
                ++i;
            };

            for (var x = 0; x < model.field_size.publish(); ++x) {
                _loop(x);
            }
            model.tiles.push(tileRow);
        }

        // error check
        if (Math.pow(model.field_size.publish(), 2) !== view.tiles.length) {
            console.warn("Warning: amount of tiles(" + view.tiles.length + ") is not equal to the field_size^2 (" + model.field_size.publish() + "^2 = " + Math.pow(model.field_size.publish(), 2) + ")");
        }
    },
    setupPawnModels: function setupPawnModels() {
        var _loop2 = function _loop2(i, ilen) {
            var newPawn = new Observable();
            newPawn.publish(viewController.getCoordinates(view.pawns[i]));
            !function (i) {
                newPawn.subscribe(function (data) {
                    if (!view.pawns[i].classList.contains("place-" + data.x + "-" + data.y)) {
                        viewController.clearClass(view.pawns[i], "place");
                        view.pawns[i].classList.add("place-" + data.x + "-" + data.y);
                    }

                    // warnings and errors
                    if (data.x >= model.field_size.publish() + 1) {
                        console.warn("the x value(" + data.x + ") is to large and the pawn will appear as floating in the air");
                    }
                    if (data.y >= model.field_size.publish() + 1) {
                        console.warn("the y value(" + data.y + ") is to large and the pawn will appear as floating in the air");
                    }
                    if (data.x < -1) {
                        console.warn("the x value(" + data.x + ") is to small and the style will reset to 0");
                    }
                    if (data.y < -1) {
                        console.warn("the y value(" + data.y + ") is to small and the style will reset to 0");
                    }
                });
            }(i);
            model.pawns.push(newPawn);
        };

        for (var i = 0, ilen = view.pawns.length; i < ilen; ++i) {
            _loop2(i, ilen);
        }
    }
};

var viewController = {
    clearClass: function clearClass(element, classString) {
        var classToDelete = element.className.match(new RegExp(classString + "[-,0-9]*", "g"));
        if (classToDelete) {
            element.classList.remove(classToDelete[0]);
        }
    },
    setTileAssetLink: function setTileAssetLink() {
        var firstImgSrc = view.tiles[0].getElementsByTagName("img")[0].src;
        model.tileLocation.publish(firstImgSrc.match(/.+\//g)[0]);
        model.tileType.publish(firstImgSrc.match(/(?!\.)([a-z]{3,})$/gm)[0]);
    },
    getCoordinates: function getCoordinates(element) {
        var coords = element.className.match(/(?!place-)[0-9]+-[0-9]+/g)[0].split("-");
        return { x: parseInt(coords[0]), y: parseInt(coords[1]) };
    }
};

var EventController = {
    initial: function initial() {
        this.tileListeners();
    },
    tileListeners: function tileListeners() {
        for (var i = 0, ilen = view.tiles.length; i < ilen; ++i) {
            !function (i) {
                view.tiles[i].addEventListener("click", function (e) {
                    e.preventDefault();
                    clearInterval(model.mover.publish());
                    var x = i % model.field_size.publish();
                    var y = Math.floor(i / model.field_size.publish());
                    pathController.move(model.pawns[model.activePlayer.publish()], { x: x, y: y });
                    if (!pathController.givePathToGo(model.pawns[model.activePlayer.publish()].publish(), { x: x, y: y })) {
                        if (!view.tiles[i].classList.contains("error")) {
                            view.tiles[i].classList.add("error");
                        }
                        setTimeout(function () {
                            if (view.tiles[i].classList.contains("error")) {
                                view.tiles[i].classList.remove("error");
                            }
                        }, Math.round(model.animationSpeedInSeconds.publish() * 3 * 1000));
                    }
                });
            }(i);
        }
    }
};

var pathController = {
    move: function move(element, to) {
        this.moveOnPath(element, this.cleanPath(this.givePathToGo(element.publish(), to), to));
    },
    givePathToGo: function givePathToGo(from, to) {
        var mainList = [];
        var found = false;
        mainList.push({ x: from.x, y: from.y, step: 0 });

        for (var i = 0, ilen = mainList.length; i < ilen && !found; ++i) {

            // give every element in the main list an array of possible next moves
            var possibleNextMoves = [];

            // check if it is not outside the board
            // && check if there is no wall between the tiles
            //
            // => add to the possibilities
            if (mainList[i].x + 1 < model.field_size.publish()) {
                var object = { x: mainList[i].x + 1, y: mainList[i].y, step: mainList[i].step + 1 };
                if (!this.isWallBetween(mainList[i], object)) {
                    possibleNextMoves.push(object);
                }
            }
            if (mainList[i].x - 1 >= 0) {
                var _object = { x: mainList[i].x - 1, y: mainList[i].y, step: mainList[i].step + 1 };
                if (!this.isWallBetween(mainList[i], _object)) {
                    possibleNextMoves.push(_object);
                }
            }
            if (mainList[i].y + 1 < model.field_size.publish()) {
                var _object2 = { x: mainList[i].x, y: mainList[i].y + 1, step: mainList[i].step + 1 };
                if (!this.isWallBetween(mainList[i], _object2)) {
                    possibleNextMoves.push(_object2);
                }
            }
            if (mainList[i].y - 1 >= 0) {
                var _object3 = { x: mainList[i].x, y: mainList[i].y - 1, step: mainList[i].step + 1 };
                if (!this.isWallBetween(mainList[i], _object3)) {
                    possibleNextMoves.push(_object3);
                }
            }

            // check if there are any of the possibilities that have the same coordinates
            // && if the step has a lower or equal value
            //
            // => delete it form the possibilities
            for (var j = 0, jlen = mainList.length; j < jlen; ++j) {
                for (var k = 0, klen = possibleNextMoves.length; k < klen; ++k) {
                    if (typeof possibleNextMoves[k] !== "undefined" && typeof mainList[j] !== "undefined") {
                        if (mainList[j].x === possibleNextMoves[k].x && mainList[j].y === possibleNextMoves[k].y && mainList[j].step <= possibleNextMoves[k].step) {

                            // delete instead of splice to prevent the for loop to fail
                            delete possibleNextMoves[k];
                        }
                    }
                }
            }

            // clear undefined values
            for (var l = 0, llen = possibleNextMoves.length; l < llen; ++l) {
                if (possibleNextMoves[l] === undefined) {
                    possibleNextMoves.splice(l, 1);
                }
            }

            // add the possibilities to the main list if there are any else it stop the while loop
            for (var m = 0, mlen = possibleNextMoves.length; m < mlen; ++m) {
                if (possibleNextMoves[m] !== undefined) {
                    mainList.push(possibleNextMoves[m]);
                }
            }

            // quit searching if the end is reached
            for (var n = 0, nlen = possibleNextMoves.length; n < nlen; ++n) {
                if (possibleNextMoves[n] !== undefined) {
                    if (possibleNextMoves[n].x === to.x && possibleNextMoves[n].y === to.y) {
                        found = true;
                    }
                }
            }

            // refreshing the ilen value otherwise the loop would end
            ilen = mainList.length;
        }

        if (found) {
            return mainList;
        } else {
            return false;
        }
    },
    isWallBetween: function isWallBetween(tileOne, tileTwo) {
        var thereIsAWall = true;
        var firstDir = "";
        var secondDir = "";
        var throwError = function throwError() {
            console.warn("not able to detect a wall in the path finding function tiles out of range");
        };

        if (tileOne.x === tileTwo.x) {
            if (tileOne.y < tileTwo.y) {
                // to the top
                firstDir = "b";
                secondDir = "t";
            }
            if (tileOne.y > tileTwo.y) {
                // to the bottom
                firstDir = "t";
                secondDir = "b";
            }
            if (tileOne.y === tileTwo.y) {
                throwError();
            }
        } else if (tileOne.y === tileTwo.y) {
            if (tileOne.x < tileTwo.x) {
                // to the left
                firstDir = "r";
                secondDir = "l";
            }
            if (tileOne.x > tileTwo.x) {
                // to the right
                firstDir = "l";
                secondDir = "r";
            }
            if (tileOne.x === tileTwo.x) {
                throwError();
            }
        } else {
            throwError();
        }

        if (!this.isThereAWallOn(model.tiles[tileOne.y][tileOne.x].publish(), firstDir) && !this.isThereAWallOn(model.tiles[tileTwo.y][tileTwo.x].publish(), secondDir)) {
            thereIsAWall = false;
        }
        return thereIsAWall;
    },
    isThereAWallOn: function isThereAWallOn(tile, direction) {
        var isWall = true;
        var walls = [];
        switch (tile.type) {
            case "corner":
                switch (tile.rotation) {
                    case 0:
                        walls.push("t", "l");
                        break;
                    case 90:
                        walls.push("t", "r");
                        break;
                    case 180:
                        walls.push("b", "r");
                        break;
                    case 270:
                        walls.push("b", "l");
                        break;
                }
                break;
            case "tpoint":
                switch (tile.rotation) {
                    case 0:
                        walls.push("t");
                        break;
                    case 90:
                        walls.push("r");
                        break;
                    case 180:
                        walls.push("b");
                        break;
                    case 270:
                        walls.push("l");
                        break;
                }
                break;
            case "line":
                switch (tile.rotation) {
                    case 0:
                    case 180:
                        walls.push("t", "b");
                        break;
                    case 90:
                    case 270:
                        walls.push("l", "r");
                        break;
                }
                break;
        }
        if (walls.indexOf(direction) === -1) {
            isWall = false;
        }
        return isWall;
    },
    cleanPath: function cleanPath(path, to) {
        if (path) {
            var backwardsPath = path.reverse();
            var newPath = [];
            var indexOfTo = this.indexOfTileObject(to, backwardsPath);
            newPath.push(backwardsPath[indexOfTo]);

            for (var i = 0, ilen = backwardsPath.length; i < ilen; ++i) {
                var lastElement = newPath[newPath.length - 1];
                if (lastElement.step - 1 === backwardsPath[i].step && (lastElement.x === backwardsPath[i].x && Math.abs(lastElement.y - backwardsPath[i].y) === 1 || lastElement.y === backwardsPath[i].y && Math.abs(lastElement.x - backwardsPath[i].x) === 1) && !this.isWallBetween(lastElement, backwardsPath[i])) {
                    newPath.push(backwardsPath[i]);
                    lastElement = backwardsPath[i];
                }
            }
            return newPath.reverse();
        } else {
            return false;
        }
    },
    indexOfTileObject: function indexOfTileObject(to, array) {
        for (var i = 0, ilen = array.length; i < ilen; ++i) {
            if (array[i].x === to.x && array[i].y === to.y) {
                return i;
            }
        }
    },
    moveOnPath: function moveOnPath(element, path) {
        var placeOnPath = 0;

        if (placeOnPath < path.length) {
            element.publish({
                x: path[placeOnPath].x,
                y: path[placeOnPath].y
            });
            ++placeOnPath;
        } else {
            clearInterval(model.mover.publish());
        }

        model.mover.publish(setInterval(function () {
            if (placeOnPath < path.length) {
                element.publish({
                    x: path[placeOnPath].x,
                    y: path[placeOnPath].y
                });
                ++placeOnPath;
            } else {
                clearInterval(model.mover.publish());
            }
        }, Math.round(model.animationSpeedInSeconds.publish() * 1000)));
    }
};

!function () {
    GameController.initial();
}();