<template>
    <div class="w-1/7 h-1/7 shadow-outset absolute rounded-lg transition"
         :class="`place-${x}-${y}`">
        <img class="w-full block rounded-lg relative z--10"
             :class="`rotate-${rotation}`"
             :src="`/storage/images/tiles/${type.name}.png`"
             :alt="tile.type.description">
        <img class="absolute w-2/5 h-2/5 pin m-auto block" v-if="tile.object"
             :class="`rotate-${rotation}`"
             :src="`/storage/images/objects/${object.name}.svg`"
             :alt="tile.object.description">
    </div>
</template>

<script>
    export default {
        name: "tile",
        props: ['tile'],
        data(){
            return {
                x: this.tile.x,
                y: this.tile.y,
                rotation: this.tile.rotation,
                type: this.tile.type,
                object: this.tile.object,
            }
        }
    }
</script>