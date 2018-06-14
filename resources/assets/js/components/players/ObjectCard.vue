<template>
    <a href="#"
       class="perspective transition pointer-events-auto overflow-hidden w-3/5 sm:w-1/2 max-w-cards"
       @click.prevent="showTemp()"
       :class="{'turned-card': active, 'active-card': show}"
       :tabindex="!active?'-1':0">
        <img v-if="!active"
             src="/storage/images/card/back2.svg"
             alt="backside of the card"
             class="absolute pin block w-full max-h-cards">
        <img v-if="active"
             class="absolute pin m-auto p-1/5 transition transition-delay-long w-full max-h-cards"
             :src="`/storage/images/objects/${object.name}.svg`"
             :alt="object.description">
        <img src="/storage/images/card/front2.svg"
             alt="the front of the card"
             class="block transition transition-delay-long w-full max-h-cards"
             :class="{'opacity-0': !active}">
        <slot></slot>
    </a>
</template>

<script>
export default {
    name: 'ObjectCard',
    props: ['object', 'placement'],
    data() {
        return {
            show: false,
        };
    },
    computed: {
        active() {
            return this.object;
        },
    },
    methods: {
        showTemp() {
            clearTimeout(reset);

            const reset = setTimeout(() => {
                this.show = false;
            }, 750);

            this.show = true;
        },
    },
};
</script>
