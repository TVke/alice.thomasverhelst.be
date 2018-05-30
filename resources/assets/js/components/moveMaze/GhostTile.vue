<template>
    <a href="#" class="w-1/7 h-1/7 shadow-inner absolute rounded-lg tr bg-grey-lighter opacity-75 hover:opacity-100 focus-opacity-100 focus:opacity-100 group"
       :class="`place-${xPos}-${yPos}`" @click.prevent="$emit('add-tile',{ x:xPos, y:yPos })">
        <a href="#" tabindex="-1" role="presentation"
           class="absolute opacity-0 group-hover:opacity-100 pin-t pin-r bg-alice rounded-full p-2 z-50 shadow -mt-2 -mr-2 w-8 h-8"
           @click.stop.prevent="$emit('rotate')">
            <img src="/storage/images/rotate.svg" alt="rotate the tile" class="w-full">
        </a>
        <img class="w-full rounded-lg relative z--10 opacity-25 group-hover:opacity-100 transition transition-property-transform" v-if="this.tile.type"
             :class="`rotate-${this.tile.rotation}`"
             :src="`/storage/images/tiles/${this.tile.type.name}.svg`"
             :alt="this.tile.type.description">
        <img class="absolute w-2/5 h-2/5 pin m-auto block transition transition-property-transform" v-if="this.tile.object"
             :src="`/storage/images/objects/${this.tile.object.name}.svg`"
             :alt="this.tile.object.description">
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
        };
    },
};
</script>
