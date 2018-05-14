<template>
    <div>
        <img :src="pawn.src" :alt="pawn.alt">
    </div>
</template>

<script>
    export default {
        name: "Player",
        props: ['pawn'],
    }
</script>

<style scoped>

</style>