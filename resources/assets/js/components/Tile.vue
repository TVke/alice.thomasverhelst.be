<template>
    <a href="#" class="w-1/7 h-1/7 absolute transition"
       :class="[`place-${tile.x}-${tile.y}`, {'z-50 filter-gray': applyError}]" aria-live="polite"
       :title="applyError ? 'You can\'t move here.' : tile.object ? tile.type.description + ' with ' + tile.object.description : 'empty ' + tile.type.description"
       :aria-label="applyError ? 'You can\'t move here.' : tile.object ? tile.type.description + ' with ' + tile.object.description : 'empty ' + tile.type.description"
       @click.prevent="$emit('tile-click',{x:tile.x,y:tile.y})">
        <img class="w-full block relative z--10"
             :class="`rotate-${tile.rotation}`"
             :src="`/storage/images/tiles/${tile.type.name}.svg`"
             :alt="tile.type.description">
        <img class="absolute w-2/5 h-2/5 pin m-auto block" v-if="tile.object"
             :src="`/storage/images/objects/${tile.object.name}.svg`"
             :alt="tile.object.description">
    </a>
</template>

<script>
export default {
    name: 'tile',
    props: ['tile', 'error'],
    computed: {
        applyError() {
            return this.error.x === this.tile.x && this.error.y === this.tile.y;
        },
    },
};
</script>
