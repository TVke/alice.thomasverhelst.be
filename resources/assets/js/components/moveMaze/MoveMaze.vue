<template>
    <div class="block transition transition-slow"
         :class="{hidden: !active}">
        <ghost-tile v-for="leftTile in 7" :x="-1" :y="leftTile - 1" :tile="tile" :key="leftTile"
                    @add-tile="addTile" @rotate="$emit('rotate', $event)">
        </ghost-tile>
        <ghost-tile v-for="topTile in 7" :x="7 - topTile" :y="-1" :tile="tile" :key="topTile + 7"
                    @add-tile="addTile" @rotate="$emit('rotate', $event)">
        </ghost-tile>
        <ghost-tile v-for="rightTile in 7" :x="7" :y="rightTile - 1" :tile="tile" :key="rightTile + 14"
                    @add-tile="addTile" @rotate="$emit('rotate', $event)">
        </ghost-tile>
        <ghost-tile v-for="bottomTile in 7" :x="7 - bottomTile" :y="7" :tile="tile" :key="bottomTile + 21"
                    @add-tile="addTile" @rotate="$emit('rotate', $event)">
        </ghost-tile>
    </div>
</template>

<script>
    import GhostTile from './GhostTile.vue';

    export default {
        name: 'MoveMaze',
        components: {GhostTile},
        props: ['active','tile'],
        methods: {
            addTile(position) {
                let x = position.x;
                let y = position.y;

                if (x === -1) {
                    this.$emit('move-maze',{
                        direction: 'x',
                        lineDirection: 'y',
                        line: y,
                        amount: 1,
                    })
                }
                if (y === -1) {
                    this.$emit('move-maze',{
                        direction: 'y',
                        lineDirection: 'x',
                        line: x,
                        amount: 1,
                    })
                }
                if (x === 7) {
                    this.$emit('move-maze',{
                        direction: 'x',
                        lineDirection: 'y',
                        line: y,
                        amount: -1,
                    })
                }
                if (y === 7) {
                    this.$emit('move-maze',{
                        direction: 'y',
                        lineDirection: 'x',
                        line: x,
                        amount: -1,
                    })
                }

                this.$emit('end-move');
            }
        }
    }
</script>