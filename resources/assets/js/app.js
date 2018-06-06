require('./bootstrap');

window.Vue = require('vue');

window.Event = new Vue();

Vue.component('players', require('./components/players/Players.vue'));
Vue.component('game-actions', require('./components/GameActions.vue'));
Vue.component('game-board', require('./components/GameBoard.vue'));
Vue.component('qrcode', require('@xkeshi/vue-qrcode'));

new Vue({
    el: '#game',
    data() {
        return {
            players: [],
            setupDone: false,
            pawnOptions: [
                { name: 'Alice', value: 'Alice' },
                { name: 'Mad Hatter', value: 'Mad Hatter' },
                { name: 'Queen of Hearts', value: 'Queen of Hearts' },
                { name: 'White Rabbit', value: 'White Rabbit' },
            ],
        };
    },
    created() {
        Event.$on('game-started', () => {
            this.setupDone = true;
        });
    },
    computed: {
        allowNewPlayer() {
            return this.players.length < 4;
        },
        gameCanStart() {
            return this.players.length >= 2;
        },
    },
    methods: {
        setupIsDone(token) {
            window.axios.patch(`/start/game/${token}`);
        },
        optionAvailable(pawnOption, players) {
            let available = false;

            players.forEach(player => {
                if (player.pawn === pawnOption.value) {
                    available = true;
                }
            });

            return available;
        },
    },
});
