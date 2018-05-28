/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Event = new Vue();

Vue.component('game-setup', require('./components/setup/GameSetup.vue'));
Vue.component('player-cards', require('./components/players/Players.vue'));
Vue.component('game-actions', require('./components/GameActions.vue'));
Vue.component('game-board', require('./components/GameBoard.vue'));

new Vue({
    el: '#game',
});
