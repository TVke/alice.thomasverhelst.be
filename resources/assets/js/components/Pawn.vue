<template>
    <div class="block w-1/7 h-1/7 absolute preserve3d transition transition-fast"
         :class="`place-${player.position.x}-${player.position.y} z-${order}`"
         @keyup.up.prevent="$emit('pawn-move', { x: player.position.x - 1, y: player.position.y })"
         @keyup.down.prevent="$emit('pawn-move', { x: player.position.x + 1, y: player.position.y })"
         @keyup.left.prevent="$emit('pawn-move', { x: player.position.x, y: player.position.y - 1 })"
         @keyup.right.prevent="$emit('pawn-move', { x: player.position.x, y: player.position.y + 1 })"
    >
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
        },
    },
    computed: {
        order() {
            if (this.player.pawn === 'White Rabbit') {
                return 20;
            }

            if (this.player.pawn === 'Alice') {
                return 30;
            }

            if (this.player.pawn === 'Queen of Hearts') {
                return 40;
            }

            return 10;
        },
    },
};
</script>
