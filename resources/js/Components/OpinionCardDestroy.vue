<template>
    <button
        class="text-white px-6 py-2 rounded-md bg-red-500 shadow hover:bg-red-600 font-bold"
        @click="destroy(opinion)"
    >
        <slot></slot>
    </button>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        opinion: Object,
    },
    methods: {
        destroy(opinion) {
            Inertia.delete(route("opinion.delete", opinion.id), {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },
    },
};
</script>