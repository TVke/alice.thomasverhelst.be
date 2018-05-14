<template>
    <div class="w-1/7 h-1/7 shadow-outset relative rounded-lg">
        <img class="w-full block rounded-lg rotate-0 relative z--10"
             :src="tileImage.src" :alt="tileImage.alt">
        <img class="absolute w-2/5 h-2/5 pin m-auto block" v-if="tile.object"
             :src="objectImage.src" :alt="objectImage.alt">

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
                const extension = 'min.svg';

                return {
                    src: `${tileUrl}/${this.tile.object.name}.${extension}`,
                    alt: this.tile.object.description,
                };
            }
        }
    }
</script>