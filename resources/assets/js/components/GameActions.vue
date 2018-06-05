<template>
    <div>
        <div class="flex absolute pin justify-center">
            <img v-if="object.name" :src="`/storage/images/objects/${object.name}.svg`" :alt="object.description" class="block transition m-auto w-48 shadow-glow scale-0"
                 :class="{
                     'scale-100': showObject,
                     'move-tl': objectOwner === 'Alice',
                     'move-bl': objectOwner === 'Mad Hatter',
                     'move-tr': objectOwner === 'White Rabbit',
                     'move-br': objectOwner === 'Queen of Hearts',
            }">
        </div>
        <div class="absolute pin-b pin-x flex justify-center">
            <button class="bg-alice text-white px-4 py-2 rounded my-8 block cursor-pointer transition pointer-events-auto shadow-lg hover:shadow active:shadow-inner focus:shadow-inner"
                    :class="{hidden: paused}" :aria-label="feedback" aria-live="polite" @click="handleAction()">{{ buttonText }}
            </button>
        </div>
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
            showObject: false,
            objectOwner: '',
            feedback: '',
        };
    },
    created() {
        Event.$on('game-started', () => {
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
                return 'rotate the tile';
            }

            return 'next player';
        },
    },
    methods: {
        handleAction() {
            if (this.moveMazeMode) {
                Event.$emit('rotate');

                setTimeout(() => {
                    this.feedback = '';
                }, 1000);

                this.feedback = 'rotated';

                window.axios.post('/rotate/tile');

                return;
            }

            window.axios.post('/next/player');
        },
    },
};
</script>
