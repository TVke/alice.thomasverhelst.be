<template>
    <div>
        <div class="absolute pin flex bg-black-transparent transition transition-delay-longer z-50"
             :class="{'opacity-0 pointer-events-none': !winner, 'pointer-events-auto': winner}">
            <div class="mx-auto w-1/2 sm:w-1/3 md:w-1/4">
                <img v-if="activePawn" class="mx-auto block w-full pb-4 pt-16 px-8 max-w-sm"
                     :src="`/storage/images/pawns/${activePawn}.svg`"
                     :alt="`${activePawn} pawn`">
                <h3 class="font-noteworthy text-center text-white text-5xl whitespace-normal truncate pb-4">{{ winner }}</h3>
                <p class="font-noteworthy text-center text-white text-xl pt-3">won Alice's magical maze</p>
                <ul v-if="scores" class="list-reset pt-4">
                    <li v-for="player in scores" :key="player.username" class="flex py-2 text-white">
                        <p class="pr-2">-</p>
                        <img class="block w-8 h-full pr-2"
                             :src="`/storage/images/pawns/${player.pawn}.svg`"
                             :alt="`${player.pawn} pawn`">
                        <p class="pr-2 my-auto">{{ player.username }}:</p>
                        <strong class="my-auto">{{ player.score }}</strong>
                    </li>
                </ul>
                <a href="/leaderboard"
                   class="px-4 py-2 rounded m-8 block transition shadow-lg hover:shadow active:shadow-inner focus:shadow-inner bg-alice text-white no-underline hover:underline text-center"
                   :tab-index="(winner)? 0 : -1"
                   :class="(winner)? 'pointer-events-auto' : 'pointer-events-none'"
                >
                    Leaderboard</a>
            </div>
        </div>
        <div class="flex absolute pin justify-center"
             :class="{'pointer-events-none': !showObject, 'pointer-events-auto': showObject}">
            <img class="block transition m-auto w-48 filter-shadow scale-0"
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
            <button class="px-4 py-2 rounded my-8 block transition shadow-lg hover:shadow active:shadow-inner focus:shadow-inner"
                    :class="{
                        hidden: paused,
                        'bg-grey shadow-none cursor-default pointer-events-none': !allowPlay || actionHappening || showObject,
                        'bg-alice text-white cursor-pointer pointer-events-auto': allowPlay
                    }"
                    :aria-label="feedback"
                    :disabled="!allowPlay"
                    aria-live="polite"
                    @click="handleAction()">
                {{ buttonText }}
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
            showObject: false,
            actionHappening: false,
            object: {},
            objectOwner: '',
            feedback: '',
            activePawn: '',
            winner: '',
            scores: [],
            objectSound: null,
            winSound: null,
            looseSound: null,
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

        Event.$on('object-found', ({ object, pawn }) => {
            setTimeout(() => {
                this.object = {};

                this.showObject = false;

                this.objectOwner = '';
            }, 2500);

            setTimeout(() => {
                this.objectOwner = pawn;
            }, 2000);

            setTimeout(() => {
                this.showObject = true;

                if (this.objectSound) {
                    this.objectSound.play();
                }
            }, 250);

            this.object = object;
        });

        Event.$on('pawn-moving', () => {
            this.actionHappening = true;
        });

        Event.$on('player-may-change', () => {
            this.actionHappening = false;
        });

        Event.$on('player-changed', pawn => {
            this.activePawn = pawn;

            this.moveMazeMode = true;
        });

        Event.$on('player-won', ({ username, scores }) => {
            this.winner = username;
            console.log(scores);
            this.scores = scores;
        });
    },
    mounted() {
        this.objectSound = document.getElementById('objectSound');
        this.winSound = document.getElementById('winSound');
        this.looseSound = document.getElementById('looseSound');
    },
    computed: {
        buttonText() {
            if (!this.allowPlay) {
                const article = this.activePawn === 'Alice' ? '' : ' the';

                return `waiting on${article} ${this.activePawn} ...`;
            }

            if (this.moveMazeMode) {
                return 'rotate the tile';
            }

            return 'next player';
        },
        allowPlay() {
            return this.activePawn === this.playerpawn;
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
