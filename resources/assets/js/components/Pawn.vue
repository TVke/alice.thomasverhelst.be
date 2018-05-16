<template>
    <div class="block w-1/7 h-1/7 absolute preserve3d"
         :class="{
             'place-0-0': placement.top && placement.left,
             'place-0-6': placement.bottom && placement.left,
             'place-6-6': placement.bottom && placement.right,
             'place-6-0': placement.top && placement.right,
             }">
        <img class="m-auto block absolute pin w-3/5 straighten-pawn origin-bottom"
             :src="`/storage/images/pawns/${player.pawn}.svg`" :alt="`${player.pawn} pawn`">
    </div>
</template>

<script>
    export default {
        name: "pawn",
        props: ['player'],
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