// !function(window, undefined) {
//
// }(window);

const Observable = function() {
    const _self = this;
    _self.data;
    _self.subs = [];
    _self.methods = {
        publish: function (newData) {
            if (typeof newData !== 'undefined') {
                _self.data = newData;
                for (let i = 0, ilen = _self.subs.length; i < ilen; ++i) {
                    _self.subs[i](_self.data);
                }
            } else {
                return _self.data;
            }
        },
        subscribe: function (callback) {
            if (_self.subs.indexOf(callback) === -1) {
                _self.subs.push(callback);
            }
        },
        unsubscribe: function (callback) {
            if (_self.subs.indexOf(callback) !== -1) {
                _self.subs.splice(_self.subs.indexOf(callback),1);
            }
        }
    };
    return _self.methods;
};

const view = {
    game_field: document.getElementsByClassName("game")[0],
    pawns: document.querySelectorAll(".pawns>[id^=pawn-]"),
    tiles: document.getElementsByClassName("tile"),
};

const model = {
    field_size: new Observable(),
    tiles: [],
    pawns: [],
    tileLocation: new Observable(),
    tileType: new Observable(),
    animationSpeedInSeconds: new Observable(),
    activePlayer: new Observable(),
};
const GameController = {
    initial: function () {
        GameFieldController.initial();
        EventController.initial();
        model.animationSpeedInSeconds.publish(.3);
        model.activePlayer.publish(0);
    }
};
const GameFieldController = {
    initial: function () {
        viewController.setTileAssetLink();
        this.setupTileModels();
        this.setupPawnModels();
    },
    setupTileModels: function () {
        model.field_size.publish(parseInt(view.game_field.dataset.field_size));
        let i = 0;
        for(let y = 0;y < model.field_size.publish();++y){
            let tileRow = [];
            for(let x = 0;x < model.field_size.publish();++x){
                let newTile = new Observable();
                newTile.publish({
                    x: x,
                    y: y,
                    type: view.tiles[i].dataset.tileType,
                    rotation: parseInt(view.tiles[i].dataset.tileRotation)
                });
                !function (i) {
                    newTile.subscribe(function (data) {
                        let tile = view.tiles[i];
                        let tileImage = tile.getElementsByTagName("img")[0];

                        if(!tile.classList.contains("place-" + data.x + "-" + data.y)){
                            viewController.clearClass(tile,"place");
                            tile.classList.add("place-" + data.x + "-" + data.y);
                        }
                        if(!tileImage.classList.contains("rotate-" + data.rotation)){
                            viewController.clearClass(tileImage,"rotate");
                            tileImage.classList.add("rotate-" + data.rotation);
                        }
                        if(tileImage.src !== model.tileLocation.publish() + data.type + "." + model.tileType.publish()){
                            tileImage.src = model.tileLocation.publish() + data.type + "." + model.tileType.publish();
                        }

                        // errors
                        if(data.x >= model.field_size.publish()+1){
                            console.warn("the x value(" + data.x + ") is to large and the tile will appear as floating in the air");
                        }
                        if(data.y >= model.field_size.publish()+1){
                            console.warn("the y value(" + data.y + ") is to large and the tile will appear as floating in the air");
                        }
                        if(data.x < -1){
                            console.warn("the x value(" + data.x + ") is to small and the style will reset to 0");
                        }
                        if(data.y < -1){
                            console.warn("the y value(" + data.y + ") is to small and the style will reset to 0");
                        }
                        if(data.rotation !== 0 && data.rotation !== 90 && data.rotation !== 180 && data.rotation !== 270){
                            console.warn("the rotation value(" + data.rotation + ") is not in the range of options and the style will reset to 0");
                        }
                        if(data.type !== "corner" && data.type !== "tpoint" && data.type !== "line"){
                            console.error("the tile type value(" + data.type + ") is not in the range of options and it will disappear!");
                        }
                    });
                }(i);
                tileRow.push(newTile);
                ++i;
            }
            model.tiles.push(tileRow);
        }

        // error check
        if(Math.pow(model.field_size.publish(),2) !== view.tiles.length){
            console.warn("Warning: amount of tiles("+ view.tiles.length +") is not equal to the field_size^2 ("+ model.field_size.publish() +"^2 = "+ Math.pow(model.field_size.publish(),2) +")");
        }
    },
    setupPawnModels: function () {
        for(let i = 0,ilen = view.pawns.length;i < ilen;++i){
            let newPawn = new Observable();
            newPawn.publish(viewController.getCoordinates(view.pawns[i]));
            !function(i) {
                newPawn.subscribe(function (data) {
                    if(!view.pawns[i].classList.contains("place-" + data.x + "-" + data.y)){
                        viewController.clearClass(view.pawns[i],"place");
                        view.pawns[i].classList.add("place-" + data.x + "-" + data.y);
                    }

                    // errors
                    if(data.x >= model.field_size.publish()+1){
                        console.warn("the x value(" + data.x + ") is to large and the pawn will appear as floating in the air");
                    }
                    if(data.y >= model.field_size.publish()+1){
                        console.warn("the y value(" + data.y + ") is to large and the pawn will appear as floating in the air");
                    }
                    if(data.x < -1){
                        console.warn("the x value(" + data.x + ") is to small and the style will reset to 0");
                    }
                    if(data.y < -1){
                        console.warn("the y value(" + data.y + ") is to small and the style will reset to 0");
                    }
                });
            }(i);
            model.pawns.push(newPawn);
        }
    },
};

const viewController = {
    clearClass: function (element, classString) {
        let classToDelete = element.className.match(new RegExp(classString + "[-,0-9]*","g"));
        if(classToDelete){
            element.classList.remove(classToDelete[0]);
        }
    },
    setTileAssetLink: function () {
        const firstImgSrc = view.tiles[0].getElementsByTagName("img")[0].src;
        model.tileLocation.publish(firstImgSrc.match(/.+\//g)[0]);
        model.tileType.publish(firstImgSrc.match(/(?!\.)([a-z]{3,})$/gm)[0]);
    },
    getCoordinates: function (element) {
        let coords = element.className.match(/(?!place-)[0-9]+-[0-9]+/g)[0].split("-");
        return {x:parseInt(coords[0]), y:parseInt(coords[1])}
    }
};

const EventController = {
    initial: function () {
        this.tileListeners();
    },
    tileListeners: function () {
        for(let i = 0,ilen = view.tiles.length;i < ilen;++i){
            !function (i) {
                view.tiles[i].addEventListener("click",function () {
                    const x = i%model.field_size.publish();
                    const y = Math.floor(i/model.field_size.publish());
                    console.log("x: "+ x +" y: "+ y);
                    pathController.move(model.pawns[model.activePlayer.publish()],{x: x,y: y})
                });
            }(i);
        }
    },
};

const pathController = {
    move: function (element, to) {
        this.moveOnPath(element, this.cleanPath(this.givePathToGo(element.publish(), to)));
    },
    givePathToGo: function (from, to) {
        let mainList = [];
        let found = false;
        mainList.push({x:from.x, y:from.y, step:0});

        for(let i = 0,ilen = mainList.length;i < ilen && !found;++i){

            // give every element in the main list an array of possible next moves
            let possibleNextMoves = [];

            // check if it is not outside the board
            // && check if there is no wall between the tiles
            //
            // => add to the possibilities
            if(mainList[i].x+1 < model.field_size.publish()){
                let object = {x:mainList[i].x+1,y:mainList[i].y,step:mainList[i].step+1};
                if(!this.isWallBetween(mainList[i], object)){
                    possibleNextMoves.push(object);
                }
            }
            if(mainList[i].x-1 >= 0){
                let object = {x:mainList[i].x-1,y:mainList[i].y,step:mainList[i].step+1};
                if(!this.isWallBetween(mainList[i], object)){
                    possibleNextMoves.push(object);
                }
            }
            if(mainList[i].y+1 < model.field_size.publish()){
                let object = {x:mainList[i].x,y:mainList[i].y+1,step:mainList[i].step+1};
                if(!this.isWallBetween(mainList[i], object)){
                    possibleNextMoves.push(object);
                }
            }
            if(mainList[i].y-1 >= 0){
                let object = {x:mainList[i].x,y:mainList[i].y-1,step:mainList[i].step+1};
                if(!this.isWallBetween(mainList[i], object)){
                    possibleNextMoves.push(object);
                }
            }

            // check if there are any of the possibilities that have the same coordinates
            // && if the step has a lower or equal value
            //
            // => delete it form the possibilities
            for(let j = 0,jlen = mainList.length;j < jlen;++j){
                for(let k = 0,klen = possibleNextMoves.length;k < klen;++k){
                    if(typeof possibleNextMoves[k] !=="undefined" && typeof mainList[j] !=="undefined"){
                        if(mainList[j].x === possibleNextMoves[k].x &&
                            mainList[j].y === possibleNextMoves[k].y &&
                            mainList[j].step <= possibleNextMoves[k].step){

                            // delete instead of splice to prevent the for loop to fail
                            delete possibleNextMoves[k];
                        }
                    }
                }
            }

            // clear undefined values
            for(let l = 0,llen = possibleNextMoves.length;l < llen;++l){
                if(possibleNextMoves[l] === undefined){
                    possibleNextMoves.splice(l,1);
                }
            }

            // add the possibilities to the main list if there are any else it stop the while loop
            for(let m = 0,mlen = possibleNextMoves.length;m < mlen;++m){
                if(possibleNextMoves[m] !== undefined){
                    mainList.push(possibleNextMoves[m]);
                }
            }

            // quit searching if the end is reached
            for(let n = 0,nlen = possibleNextMoves.length;n < nlen;++n){
                if(possibleNextMoves[n] !== undefined){
                    if(possibleNextMoves[n].x === to.x && possibleNextMoves[n].y === to.y){
                        found = true;
                    }
                }
            }

            // refreshing the ilen value otherwise the loop would end
            ilen = mainList.length;
        }

        if(found){
            return mainList;
        }
        else{
            return false;
        }
    },
    isWallBetween: function(tileOne,tileTwo){
        let thereIsAWall = true;
        let firstDir = "";
        let secondDir = "";
        const throwError = function () {
            console.warn("not able to detect a wall in the path finding function tiles out of range");
        };

        if(tileOne.x === tileTwo.x){
            if(tileOne.y < tileTwo.y){ // to the top
                firstDir = "b";
                secondDir = "t";
            }
            if(tileOne.y > tileTwo.y){ // to the bottom
                firstDir = "t";
                secondDir = "b";
            }
            if(tileOne.y === tileTwo.y){
                throwError();
            }
        }
        else if(tileOne.y === tileTwo.y){
            if(tileOne.x < tileTwo.x){ // to the left
                firstDir = "r";
                secondDir = "l";
            }
            if(tileOne.x > tileTwo.x){ // to the right
                firstDir = "l";
                secondDir = "r";
            }
            if(tileOne.x === tileTwo.x){
                throwError();
            }
        }
        else{
            throwError();
        }

        if(
            !this.isThereAWallOn(model.tiles[tileOne.y][tileOne.x].publish(), firstDir) &&
            !this.isThereAWallOn(model.tiles[tileTwo.y][tileTwo.x].publish(), secondDir)
        ){
            thereIsAWall = false
        }
        return thereIsAWall;
    },
    isThereAWallOn: function (tile, direction) {
        let isWall = true;
        let walls = [];
        switch (tile.type){
            case "corner":
                switch (tile.rotation){
                    case 0:
                        walls.push("t","l");
                        break;
                    case 90:
                        walls.push("t","r");
                        break;
                    case 180:
                        walls.push("b","r");
                        break;
                    case 270:
                        walls.push("b","l");
                        break;
                }
                break;
            case "tpoint":
                switch (tile.rotation){
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
                switch (tile.rotation){
                    case 0:
                    case 180:
                        walls.push("t","b");
                        break;
                    case 90:
                    case 270:
                        walls.push("l","r");
                        break;
                }
                break;
        }
        if(walls.indexOf(direction) === -1){
            isWall = false;
        }
        return isWall;
    },
    cleanPath: function (path) {
        if(path){
            let backwardsPath = path.reverse();
            let newPath = [];
            newPath.push(backwardsPath[0]);

            for(let i = 0,ilen = backwardsPath.length;i<ilen;++i){
                let lastElement = newPath[newPath.length-1];
                if(lastElement.step-1 === backwardsPath[i].step &&
                    ((lastElement.x === backwardsPath[i].x &&
                        Math.abs(lastElement.y - backwardsPath[i].y) === 1) ||
                        (lastElement.y === backwardsPath[i].y &&
                            Math.abs(lastElement.x - backwardsPath[i].x) === 1)) &&
                        !this.isWallBetween(lastElement,backwardsPath[i])
                ){
                    newPath.push(backwardsPath[i]);
                    lastElement = backwardsPath[i];
                }
            }

            return newPath.reverse();
        }else{
            return false;
        }
    },
    moveOnPath: function (element, path) {
        let placeOnPath = 0;
        setTimeout(function () {
            clearInterval(move);
        }, Math.round((model.animationSpeedInSeconds.publish()*(path.length+1))*1000));

        if(placeOnPath < path.length){
            element.publish({
                x: path[placeOnPath].x,
                y: path[placeOnPath].y
            });
            ++placeOnPath;
        }else{
            clearInterval(move);
        }

        let move = setInterval(function () {
            if(placeOnPath < path.length){
            element.publish({
                x: path[placeOnPath].x,
                y: path[placeOnPath].y
            });
                ++placeOnPath;
            }else{
                clearInterval(move);
            }
        }, Math.round(model.animationSpeedInSeconds.publish()*1000));
    },
};

!function () {
    GameController.initial();
}();