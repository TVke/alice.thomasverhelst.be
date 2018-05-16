<template>
    <div class="block w-1/7 h-1/7 absolute preserve3d transition"
         :class="`place-${x}-${y}`">
        <img class="m-auto block absolute pin w-3/5 straighten-pawn origin-bottom"
             :src="`/storage/images/pawns/${pawn}.svg`" :alt="`${pawn} pawn`">
    </div>
</template>

<script>
    export default {
        name: "pawn",
        props: ['start','pawn'],
        data(){
            return {
                x: this.start.x,
                y: this.start.y,
            }
        }
    }
</script>