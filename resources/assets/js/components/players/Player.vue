<template>
    <div class="absolute flex flex-wrap w-1/4 p-2 bg-white-transparent rounded"
         :class="{
         'pin-t': placement.top,
         'pin-r': placement.right,
         'pin-b': placement.bottom,
         'pin-l': placement.left,
         'flex-row-reverse': placement.right,
         'text-right': placement.right,
         }">
        <div class="h-full rounded-full w-12 md:w-1/4 bg-white"
             :class="{
             'border border-pawn-blue shadow-blue-active': active === 1 && player.pawn === 'Alice',
             'border border-pawn-green shadow-green-active': active === 2 && player.pawn === 'Mad Hatter',
             'border border-pawn-red shadow-red-active': active === 3 && player.pawn === 'Queen of Hearts',
             'border border-black shadow-white-active': active === 4 && player.pawn === 'White Rabbit',
             }">
            <img class="block p-1" :src="`/storage/images/pawns/${player.pawn}.svg`" :alt="`${player.pawn} pawn`">
        </div>
        <p class="my-auto p-2 truncate w-full md:w-3/4">{{ player.username }}</p>
    </div>
</template>

<script>
    import Pawn from '../Pawn.vue';

    export default {
        name: "Player",
        components: {Pawn},
        props: {
            player: {
                required: true,
                type: Object,
            },
            active: {
                type: Number,
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