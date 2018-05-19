<template>
    <div class="block w-1/7 h-1/7 absolute preserve3d transition"
         :class="`place-${x}-${y} z-${order}`">
        <img class="m-auto block absolute pin w-3/5 straighten-pawn origin-bottom"
             :src="`/storage/images/pawns/${pawn}.svg`" :alt="`${pawn} pawn`">
    </div>
</template>

<script>
    export default {
        name: 'pawn',
        props: {
            start: {
                type: Object,
            },
            pawn: {
                type: String,
            },
        },
        data() {
            return {
                x: this.start.x,
                y: this.start.y,
                activePlayer: '',
            }
        },
        created(){
            Event.$on('active-player', (event) => {
                this.activePlayer = event;
            });
            Event.$on('move-to', (event) => {

            });
        },
        computed: {
            order() {
                if (this.pawn === 'White Rabbit') {
                    return 20;
                }
                if (this.pawn === 'Alice') {
                    return 30;
                }
                if (this.pawn === 'Queen of Hearts') {
                    return 40;
                }
                return 10;
            },
            // makePath(x, y){
            //
            // }
        }
    }
</script>