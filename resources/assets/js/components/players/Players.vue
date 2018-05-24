<template>
    <div class="absolute pin">
        <player v-for="player in players" :player="player" :active="activePlayer" :objects="objects" :key="player.id" :paused="paused"></player>
    </div>
</template>

<script>
    import Player from './Player.vue';

    export default {
        name: 'Players',
        components: {Player},
        data() {
            return {
                players: [],
                activePlayer: '',
                paused: true,
                objects: [],
            }
        },
        created() {
            window.axios.get('/game/objects')
                .then(({data}) => {
                    // this.objects = this.shuffle(data);
                    this.objects = data;
                });

            Event.$on('start-play', (event) => {
                this.players = event;

                setTimeout(() => {
                    this.paused = false;
                },25);


                let option = Math.floor(Math.random() * event.length);

                this.activePlayer = this.players[option];

                this.activePlayer = this.players[option].pawn;

                Event.$emit('active-player', this.activePlayer);
            });
        },
        methods: {
            shuffle(array){
                let copy = [], n = array.length, i;

                while (n >= 0) {
                    i = Math.floor(Math.random() * --n);

                    copy.push(array.splice(i, 1)[0]);
                }

                return copy;
            }
        }
    }
</script>