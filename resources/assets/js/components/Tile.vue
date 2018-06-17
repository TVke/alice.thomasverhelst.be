<template>
    <a href="#" class="w-1/7 h-1/7 absolute transition" aria-live="polite"
       :class="[`place-${tile.x}-${tile.y}`, {'z-50 filter-gray': applyError}]"
       :title="titleContent"
       :aria-label="titleContent"
       @click.prevent="handleTileClick()">
        <img class="w-full h-full block relative z--10"
             :class="`rotate-${tile.rotation}`"
             :src="`/storage/images/tiles/${tile.type}.svg`"
             :alt="tileDescription">
        <img class="absolute w-2/5 h-2/5 pin m-auto block" v-if="tile.object"
             :src="`/storage/images/objects/${tile.object.name}.svg`"
             :alt="tileDescription">
    </a>
</template>

<script>
export default {
    name: 'tile',
    props: ['tile', 'error'],
    data(){
        return {
            pawnSound: null,
        }
    },
    mounted() {
        this.pawnSound = document.getElementById('pawnSound');
    },
    computed: {
        applyError() {
            return this.error.x === this.tile.x && this.error.y === this.tile.y;
        },
        tileDescription() {
            if (this.tile.type === 'corner') {
                return 'corner tile';
            }

            if (this.tile.type === 'tpoint') {
                return 't-point tile';
            }

            return 'straight line tile'
        },
        titleContent() {
            if (this.applyError) {
                return "You can't move here.";
            }

            if (this.tile.object) {
                return `${this.tileDescription} with ${this.tile.object.description}`
            }

            return `empty ${this.tileDescription}`
        },
    },
    methods: {
        handleTileClick(){
            this.$emit('tile-click', {x: this.tile.x, y: this.tile.y});
        }
    }
};
</script>
