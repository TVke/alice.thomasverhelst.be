<template>
    <div class="perspective transition relative" :class="{'flip-card': flipped}">
        <img src="/storage/images/card/front.svg" alt="the front of the card" class="w-full block">
        <img class="absolute pin m-auto p-16"
             v-if="!flipped" :src="`/storage/images/objects/${object.name}.svg`" :alt="object.name">
        <img src="/storage/images/card/back.svg" alt="backside of the card" class="absolute pin block flip-card">
    </div>
</template>

<script>
    export default {
        name: 'ObjectCard',
        props: ['object'],
        data(){
            return {
                flipped: true,
            }
        },
    }
</script>