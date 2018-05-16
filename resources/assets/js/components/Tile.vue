<template>
    <div class="w-1/7 h-1/7 shadow-outset absolute rounded-lg"
         :class="`place-${tile.x}-${tile.y}`">
        <img class="w-full block rounded-lg relative z--10"
             :class="`rotate-${tile.rotation}`"
             :src="`/storage/images/tiles/${tile.type.name}.png`"
             :alt="tile.type.description">
        <img class="absolute w-2/5 h-2/5 pin m-auto block" v-if="tile.object"
             :class="`rotate-${tile.rotation}`"
             :src="`/storage/images/objects/${tile.object.name}.svg`"
             :alt="tile.object.description">
    </div>
</template>

<script>
    export default {
        name: "tile",
        props: ['tile'],
        computed: {
            tileImage() {
                const tileUrl = `/storage/images/tiles`;
                const extension = 'min.svg';

                return {
                    src: `${tileUrl}/${this.tile.type.name}.${extension}`,
                    alt: this.tile.type.description,
                };
            },
            objectImage() {
                const tileUrl = `/storage/images/objects`;
                const extension = 'svg';

                return {
                    src: `${tileUrl}/${this.tile.object.name}.${extension}`,
                    alt: this.tile.object.description,
                };
            }
        }
    }
</script>