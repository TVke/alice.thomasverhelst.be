<template>
    <div class="absolute flex flex-wrap w-1/4 p-2 bg-white-transparent rounded transition-delay-longest transition"
         :class="{
         'pin-t': placement.top,
         'pin-b': placement.bottom,
         'pin-l': placement.left,
         'pin-r flex-row-reverse text-right': placement.right,
         'left-out': paused && placement.left,
         'right-out': paused && placement.right,
         'left-in': !paused && placement.left,
         'right-in': !paused && placement.right,
         }">
        <div class="h-full rounded-full w-12 md:w-1/4 bg-white"
             :class="{
             'border border-pawn-blue shadow-blue-active': active === player.pawn && player.pawn === 'Alice',
             'border border-pawn-green shadow-green-active': active === player.pawn && player.pawn === 'Mad Hatter',
             'border border-pawn-red shadow-red-active': active === player.pawn && player.pawn === 'Queen of Hearts',
             'border border-black shadow-white-active': active === player.pawn && player.pawn === 'White Rabbit',
             }">
            <img class="block p-1" :src="`/storage/images/pawns/${player.pawn}.svg`" :alt="`${player.pawn} pawn`">
        </div>
        <p class="my-auto p-2 truncate w-full md:w-3/4">{{ player.username }}</p>
    </div>
</template>

<script>
    import Pawn from '../Pawn.vue';

    export default {
        name: 'Player',
        components: {Pawn},
        props: {
            player: {
                required: true,
                type: Object,
            },
            active: {
                type: String,
            },
            paused: {
                type: Boolean,
            },
        },
        computed: {
            placement() {
                let places = {
                    top: false,
                    right: false,
                    bottom: false,
                    left: false
                };

                if (this.player.pawn === 'Alice' || this.player.pawn === 'White Rabbit') {
                    places.top = true;
                }
                if (this.player.pawn === 'White Rabbit' || this.player.pawn === 'Queen of Hearts') {
                    places.right = true;
                }
                if (this.player.pawn === 'Queen of Hearts' || this.player.pawn === 'Mad Hatter') {
                    places.bottom = true;
                }
                if (this.player.pawn === 'Mad Hatter' || this.player.pawn === 'Alice') {
                    places.left = true;
                }

                return places;
            }
        }
    }
</script>