<template>
    <div
        :class="{ 'text-red-500': opinion.like }"
        class="cursor-pointer flex hover:text-red-400"
        @click="like(opinion)"
    >
        <icons v-if="opinion.like" icon="heart-solid"></icons>

        <icons v-else icon="heart"></icons>

        <span class="pl-1">{{ opinion.likes_count }}</span>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

export default {
    props: {
        opinion: Object,
    },
    components: {
        Icons,
    },
    methods: {
        like(opinion) {
            this.$inertia.post(route("opinion.like", opinion.id), [], {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },
    },
};
</script>