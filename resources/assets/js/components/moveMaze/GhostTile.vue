<template>
    <a href="#" class="w-1/7 h-1/7 shadow-inner absolute rounded-lg tr bg-grey-lighter opacity-75 hover:opacity-100 focus-opacity-100 focus:opacity-100 group"
       :class="`place-${xPos}-${yPos}`" @click.prevent="handleTileClick()">
        <a href="#" tabindex="-1" role="presentation"
           class="absolute opacity-0 group-hover:opacity-100 pin-t pin-r bg-alice rounded-full p-2 z-50 shadow -mt-2 -mr-2 w-8 h-8 hidden sm:block"
           @click.stop.prevent="handleTileRotation()">
            <img src="/storage/images/rotate.svg" alt="rotate the tile" class="w-full">
        </a>
        <img class="w-full rounded-lg relative z--10 opacity-25 group-hover:opacity-100 transition transition-property-transform" v-if="this.tile.type"
        :class="`rotate-${this.tile.rotation}`"
        :src="`/storage/images/tiles/${this.tile.type}.svg`"
        :alt="tileDescription">
        <img class="absolute w-2/5 h-2/5 pin m-auto block transition transition-property-transform" v-if="this.tile.object"
        :src="`/storage/images/objects/${this.tile.object}.svg`"
        :alt="this.tile.object">
    </a>
</template>

<script>
export default {
    name: 'GhostTile',
    props: ['x', 'y', 'tile'],
    data() {
        return {
            xPos: this.x,
            yPos: this.y,
            tileSound: null,
            moveSound: null,
        };
    },
    mounted() {
        this.tileSound = document.getElementById('tileSound');
        this.moveSound = document.getElementById('moveSound');
    },
    computed: {
        tileDescription() {
            if (this.tile.type === 'corner') {
                return 'corner tile';
            }

            if (this.tile.type === 'tpoint') {
                return 't-point tile';
            }

            return 'straight line tile';
        },
    },
    methods: {
        handleTileClick() {
            this.$emit('add-tile', { x: this.xPos, y: this.yPos });

            if (this.tileSound) {
                this.tileSound.play();
            }

            if (this.moveSound) {
                this.moveSound.play();
            }
        },
        handleTileRotation() {
            this.$emit('rotate');

            window.axios.post('/rotate/tile');
        },
    },
};
</script>
