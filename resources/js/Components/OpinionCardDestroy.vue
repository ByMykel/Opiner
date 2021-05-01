<template>
    <button
        class="text-white px-6 py-2 rounded-md bg-red-500 shadow hover:bg-red-600 font-bold"
        @click="destroy()"
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        opinion: Object,
    },

    methods: {
        destroy() {
            this.$inertia.delete(route("opinion.delete", this.opinion.id), {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },
    },
};
</script>