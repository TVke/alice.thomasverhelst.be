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
    pawns: document.querySelectorAll(".pawns>[id^=pawn-]"),
    tiles: document.getElementsByClassName("movable-tile"),
};

const model = {

};