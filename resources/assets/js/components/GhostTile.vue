<template>
    <a href="#" class="w-1/7 h-1/7 shadow-inner absolute rounded-lg transition-property-transform tr bg-grey-lighter opacity-75 hover:opacity-100 group"
         :class="`place-${xPos}-${yPos}`" @click="$emit('add-tile',{ x:xPos, y:yPos })">
        <img class="w-full rounded-lg relative z--10 opacity-25 group-hover:opacity-100" v-if="this.tile.type"
             :class="`rotate-${this.tile.rotation}`"
             :src="`/storage/images/tiles/${this.tile.type.name}.png`"
             :alt="this.tile.type.description">
        <img class="absolute w-2/5 h-2/5 pin m-auto block" v-if="this.tile.object"
             :class="`rotate-${this.tile.rotation}`"
             :src="`/storage/images/objects/${this.tile.object.name}.svg`"
             :alt="this.tile.object.description">
    </a>
</template>

<script>
    export default {
        name: "GhostTile",
        props: ['x', 'y', 'tile'],
        data(){
            return{
                xPos: this.x,
                yPos: this.y,
            }
        }
    }
</script>