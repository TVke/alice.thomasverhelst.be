<template>
    <div class="block w-1/7 h-1/7 absolute preserve3d transition transition-fast"
         :class="`place-${player.position.x}-${player.position.y} z-${order}`">
        <img class="m-auto block absolute pin w-3/5 straighten-pawn origin-bottom"
             :src="`/storage/images/pawns/${player.pawn}.svg`" :alt="`${player.pawn} pawn`">
    </div>
</template>

<script>
    export default {
        name: 'pawn',
        props: {
            player: {
                type: Object,
                required: true,
            },
            active: {
                type: String,
                required: true,
            }
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
        },
    }
</script>