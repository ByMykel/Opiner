<template>
    <div @click="destroy(opinion)">
        <Icons
            icon="trash"
            class="text-gray-400 hover:text-blue-400 cursor-pointer"
        />
    </div>
</template>

<script>
import Icons from "@/Components/Icons";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        opinion: Object,
    },
    components: {
        Icons,
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