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
            login: false,
            selectedPawn: '',
            pawnOptions: [
                {name: 'Alice', value: 'Alice', chosen: false},
                {name: 'Mad Hatter', value: 'Mad Hatter', chosen: false},
                {name: 'Queen of Hearts', value: 'Queen of Hearts', chosen: false},
                {name: 'White Rabbit', value: 'White Rabbit', chosen: false},
            ],
            welcomeSound: null,
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

            if (this.welcomeSound) {
                this.welcomeSound.play();
            }
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
        handlePawnClick(pawnOption) {
            this.selectedPawn = pawnOption.value;
        },
        addPlayer(player) {
            this.players.push(player);

            let removeId = 0;

            let newPawn = {};

            this.pawnOptions.forEach((option, index) => {
                if (option.value === player.pawn) {
                    removeId = index;

                    option.chosen = true;

                    newPawn = option;
                }
            });

            this.pawnOptions.splice(removeId, 1, newPawn);
        },
        removePlayer(player) {
            const playerToRemove = this.players.splice(player, 1);

            let removeId = 0;

            let newPawn = {};

            this.pawnOptions.forEach((option, index) => {
                if (option.value === playerToRemove[0].pawn) {
                    removeId = index;

                    option.chosen = false;

                    newPawn = option;
                }
            });

            this.pawnOptions.splice(removeId, 1, newPawn);
        },
    },
});
