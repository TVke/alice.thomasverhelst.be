<template>
    <div class="absolute pin-b pin-x flex justify-center">
        <img v-if="object.name" :src="`/storage/images/objects/${object.name}.svg`" :alt="object.description" class="block transition"
             :class="{hidden: !object.name}">
        <button class="bg-alice text-white px-4 py-2 rounded my-8 block cursor-pointer pointer-events-auto"
                :class="{hidden: paused}" @click="handleAction()">{{ buttonText }}</button>
    </div>
</template>

<script>
export default {
    name: 'GameActions',
    data() {
        return {
            moveMazeMode: false,
            paused: true,
            object: {},
        };
    },
    created() {
        Event.$on('start-play', () => {
            this.paused = false;

            this.moveMazeMode = true;
        });

        Event.$on('maze-moved', () => {
            this.moveMazeMode = false;
        });

        Event.$on('object-found', object => {
            setTimeout(() => {
                this.object = {};
            }, 1000);

            this.object = object;
        });
    },
    computed: {
        buttonText() {
            if (this.moveMazeMode) {
                return 'rotate';
            }

            return 'next player';
        },
    },
    methods: {
        handleAction() {
            if (this.moveMazeMode) {
                Event.$emit('rotate');
            }

            // next player
        },
    },
};
</script>
