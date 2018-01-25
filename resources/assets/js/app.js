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
                            console.log(typeof data.type);
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

!function () {
    GameFieldController.initial();
}();