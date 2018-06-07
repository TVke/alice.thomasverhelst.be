<template>
    <div>
        <div class="flex absolute pin justify-center">
            <img class="block transition m-auto w-48 shadow-glow scale-0"
                 v-if="object.name"
                 :src="`/storage/images/objects/${object.name}.svg`"
                 :alt="object.description"
                 :class="{
                     'scale-100': showObject,
                     'move-tl': objectOwner === 'Alice',
                     'move-bl': objectOwner === 'Mad Hatter',
                     'move-tr': objectOwner === 'White Rabbit',
                     'move-br': objectOwner === 'Queen of Hearts',
            }">
        </div>
        <div class="absolute pin-b pin-x flex justify-center">
            <button class="px-4 py-2 rounded my-8 block transition pointer-events-auto shadow-lg hover:shadow active:shadow-inner focus:shadow-inner"
                    :class="{
                    hidden: paused,
                    'bg-grey shadow-none cursor-default': !allowPlay,
                    'bg-alice text-white cursor-pointer': allowPlay
                    }"
                    :aria-label="feedback"
                    :disabled="!allowPlay"
                    aria-live="polite"
                    @click="handleAction()">{{ buttonText }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'GameActions',
    props: ['playerpawn'],
    data() {
        return {
            moveMazeMode: false,
            paused: true,
            object: {},
            showObject: false,
            objectOwner: '',
            feedback: '',
            activePawn: '',
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

        Event.$on('player-changed', ({pawn}) => {
            this.activePawn = pawn;
        });
    },
    computed: {
        buttonText() {
            if (! this.allowPlay){
                const article = this.activePawn === 'Alice' ? '' : ' the';

                return `waiting on${article} ${this.activePawn} ...`
            }

            if (this.moveMazeMode) {
                return 'rotate the tile';
            }

            return 'next player';
        },
        allowPlay(){
            return this.activePawn === this.playerpawn;
        }
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
