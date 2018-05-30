<template>
    <a href="#" class="perspective transition relative pointer-events-auto overflow-hidden"
       @click.prevent="showTemp()" :class="{'turned-card': active,'active-card': show}" :tabindex="!active?'-1':0">
        <img src="/storage/images/card/back2.svg" alt="backside of the card" class="absolute pin block z--10"
             :class="{'hide-card opacity-0': active}">
        <img class="absolute pin m-auto p-1/5 transition transition-delay-long" v-if="active" :class="{'hide-card opacity-0': !active}"
             :src="`/storage/images/objects/${object.name}.svg`" :alt="object.name">
        <img src="/storage/images/card/front2.svg" alt="the front of the card" class="w-full block transition transition-delay-long"
             :class="{'hide-card opacity-0': !active}">
    </a>
</template>

<script>
export default {
    name: 'ObjectCard',
    props: ['object', 'active'],
    data() {
        return {
            show: false,
        };
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
