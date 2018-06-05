<template>
    <div>
        <div class="absolute flex flex-wrap w-1/4 p-2 bg-white-transparent rounded transition-delay-longest transition z-10"
             :class="{
                 'pin-t': placement.top,
                 'pin-b': placement.bottom,
                 'pin-l': placement.left,
                 'pin-r flex-row-reverse text-right': placement.right,
                 'left-out': paused && placement.left,
                 'right-out': paused && placement.right,
                 'translateX-0': !paused,
                 'bg-active-transparent text-white': active === player.pawn,
        }">
            <div class="h-full rounded-full w-12 md:w-1/4 bg-white"
                 :class="{
                     'border border-pawn-blue shadow-blue-active': active === player.pawn && player.pawn === 'Alice',
                     'border border-pawn-green shadow-green-active': active === player.pawn && player.pawn === 'Mad Hatter',
                     'border border-pawn-red shadow-red-active': active === player.pawn && player.pawn === 'Queen of Hearts',
                     'border border-black shadow-white-active bg-black-transparent': active === player.pawn && player.pawn === 'White Rabbit',
            }">
                <img class="block p-1" :src="`/storage/images/pawns/${player.pawn}.svg`" :alt="`${player.pawn} pawn`">
            </div>
            <p class="my-auto p-2 truncate w-full md:w-3/4">{{ player.username }}</p>
        </div>
        <div class="flex absolute w-1/4 py-12 md:py-4" :class="{
            'pin-t': placement.top,
            'pin-b': placement.bottom,
            'pin-l pl-12 ml-4': placement.left,
            'pin-r pr-12 flex-row-reverse mr-4': placement.right
        }">
            <object-card v-for="card in objects"
                         :key="card"
                         :class="{'-ml-8': placement.left,'-mr-8': placement.right}"></object-card>
            <object-card v-if="current.pawn === player.pawn"
                         :object="JSON.parse(current.object)"
                         :class="{'-ml-8': placement.left,'-mr-8': placement.right}"></object-card>
        </div>
    </div>
</template>

<script>
import ObjectCard from './ObjectCard.vue';

export default {
    name: 'Player',
    components: { ObjectCard },
    props: {
        player: {
            required: true,
            type: Object,
        },
        current: {
            required: true,
            type: Object,
        },
        objects:{
            required: true,
            type: Number,
        },
        active: {
            type: String,
        },
        paused: {
            type: Boolean,
        },
    },
    computed: {
        placement() {
            let places = {
                top: false,
                right: false,
                bottom: false,
                left: false,
            };

            if (this.player.pawn === 'Alice' || this.player.pawn === 'White Rabbit') {
                places.top = true;
            }
            if (this.player.pawn === 'White Rabbit' || this.player.pawn === 'Queen of Hearts') {
                places.right = true;
            }
            if (this.player.pawn === 'Queen of Hearts' || this.player.pawn === 'Mad Hatter') {
                places.bottom = true;
            }
            if (this.player.pawn === 'Mad Hatter' || this.player.pawn === 'Alice') {
                places.left = true;
            }

            return places;
        },
    },
};
</script>
