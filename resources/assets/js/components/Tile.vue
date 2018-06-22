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
             :src="`/storage/images/objects/${tile.object}.svg`"
             :alt="objectDescription">
    </a>
</template>

<script>
    export default {
        name: 'tile',
        props: ['tile', 'error'],
        data() {
            return {
                pawnSound: null,
            };
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

                return 'straight line tile';
            },
            titleContent() {
                if (this.applyError) {
                    return "You can't move here.";
                }

                if (this.tile.object) {
                    return `${this.tileDescription} with ${this.objectDescription}`;
                }

                return `empty ${this.tileDescription}`;
            },
            objectDescription() {
                if (!this.tile.object) {
                    return '';
                }

                if (this.tile.object === 'cake') {
                    return 'a cupcake with "eat me" on it'
                }

                if (this.tile.object === 'doorknob') {
                    return 'a doorknob in the shape of a face'
                }

                if (this.tile.object === 'bottle') {
                    return 'a bottle with "drink me" on it'
                }

                if (this.tile.object === 'golfmallets') {
                    return 'a bag of flamingo mallets'
                }

                if (this.tile.object === 'golfbal') {
                    return 'a hedgehog in the shape of a bal'
                }

                if (this.tile.object === 'hats') {
                    return 'the hats of Tweedledum and Tweedledee'
                }

                if (this.tile.object === 'cardsoldiers') {
                    return 'the card soldiers of the Queen of Hearts'
                }

                if (this.tile.object === 'hearts') {
                    return 'a hearts card'
                }

                if (this.tile.object === 'clubs') {
                    return 'a clubs card'
                }

                if (this.tile.object === 'spades') {
                    return 'a spades card'
                }

                if (this.tile.object === 'diamonds') {
                    return 'a diamonds card'
                }

                if (this.tile.object === 'crown') {
                    return 'the crown of the Queen of Hearts'
                }

                if (this.tile.object === 'whiterose') {
                    return 'a white rose'
                }

                if (this.tile.object === 'redrose') {
                    return 'a painted, red rose'
                }

                if (this.tile.object === 'shoe') {
                    return 'the shoe of Alice'
                }

                if (this.tile.object === 'key') {
                    return 'the key to enter Wonderland'
                }

                if (this.tile.object === 'waterpipe') {
                    return 'the waterpipe of Ipsolum'
                }

                if (this.tile.object === 'singingflower') {
                    return 'a singing flower'
                }

                if (this.tile.object === 'pocketwatch') {
                    return 'the pocketwatch of the White Rabbit'
                }

                if (this.tile.object === 'mirror') {
                    return 'the mirror from Alice through the looking glass'
                }

                if (this.tile.object === 'teacup') {
                    return 'a teacup from the table of the Mad Hatter'
                }

                if (this.tile.object === 'teapot') {
                    return 'a teapot from the table of the Mad Hatter'
                }

                if (this.tile.object === 'tree') {
                    return 'a tree with a rabbit hole'
                }

                if (this.tile.object === 'hammer') {
                    return 'the judge hammer of the Queen of Hearts'
                }

                return '';
            },
        },
        methods: {
            handleTileClick() {
                this.$emit('tile-click', {x: this.tile.x, y: this.tile.y});
            },
        },
    };
</script>
