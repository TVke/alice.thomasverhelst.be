<template>
    <div class="absolute w-1/4 flex" :class="{
    'pin-t flex-col': placement.top,
    'pin-b flex-col-reverse': placement.bottom,
    'pin-l': placement.left,
    'pin-r': placement.right,
    }">
        <div class="flex flex-wrap p-2 bg-white-transparent rounded transition-delay-longest transition z-10 block w-full"
             :class="{
                 'pin-t': placement.top,
                 'pin-b': placement.bottom,
                 'pin-l': placement.left,
                 'pin-r flex-row-reverse text-right': placement.right,
                 'left-out': paused && placement.left,
                 'right-out': paused && placement.right,
                 'translateX-0': !paused,
        }">
            <div class="h-full rounded-full w-12 md:w-1/4 bg-white filter-gray"
                 :class="{
                     'no-filter border border-pawn-blue shadow-blue-active': active === player.pawn && player.pawn === 'Alice',
                     'no-filter border border-pawn-green shadow-green-active': active === player.pawn && player.pawn === 'Mad Hatter',
                     'no-filter border border-pawn-red shadow-red-active': active === player.pawn && player.pawn === 'Queen of Hearts',
                     'no-filter border border-black shadow-white-active bg-black-transparent': active === player.pawn && player.pawn === 'White Rabbit',
            }">
                <img class="block p-1" :src="`/storage/images/pawns/${player.pawn}.svg`" :alt="`${player.pawn} pawn`">
            </div>
            <p class="my-auto p-2 truncate w-full md:w-3/4">{{ player.username }}</p>
        </div>
        <div class="flex" :class="{
            'pin-t flex-col-reverse': placement.top,
            'pin-b flex-col': placement.bottom,
            'pin-l ml-4 items-start': placement.left,
            'pin-r mr-4 items-end': placement.right,
            'z-50': current.object && current.pawn === player.pawn,
        }">
            <object-card v-for="card in objectsToShow"
                         :placement="placement"
                         :key="card"
                         :class="{'-mb-16 xs:-mb-18 sm:-mb-24 md:-mb-28': placement.top,'-mt-16 xs:-mt-18 sm:-mt-24 md:-mt-28': placement.bottom}"
            ></object-card>
            <object-card v-if="current.object && current.pawn === player.pawn"
                         :placement="placement"
                         :object="current.object"
                         :class="{'-mb-16 xs:-mb-18 sm:-mb-24 md:-mb-28': placement.top,'-mt-16 xs:-mt-18 sm:-mt-24 md:-mt-28': placement.bottom}"
            ></object-card>
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
        objects: {
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
    data() {
        return {
            objectsToShow: this.objects,
        };
    },
    created() {
        Event.$on('object-found', ({ object, pawn }) => {
            if (pawn === this.player.pawn) {
                if (this.objectsToShow > 0) {
                    this.objectsToShow -= 1;
                }
            }
        });
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
