<template>
    <div class="w-1/7 h-1/7 shadow-inner absolute rounded-lg transition bg-grey-lighter opacity-75"
         :class="`place-${this.x}-${this.y}`" v-on:mouseover="hover">
    </div>
</template>

<script>
    export default {
        name: "GhostTile",
        props: ['x', 'y'],
        methods: {
            hover() {
                console.log('hover');
            }
        }
    }
</script>