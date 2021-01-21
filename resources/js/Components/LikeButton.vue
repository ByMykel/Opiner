<template>
    <div
        class="cursor-pointer flex hover:text-red-400"
        :class="{ 'text-red-500': opinion.like }"
        @click="like(opinion)"
    >
        <Icons v-if="opinion.like" icon="heart-solid" />
        <Icons v-else icon="heart" />
        <span class="pl-1">{{ opinion.likes_count }}</span>
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
        Icons
    },
    methods: {
        like(opinion) {
            Inertia.post(route("opinion.like", opinion.id), [], {
                preserveScroll: true,
                resetOnSuccess: false,
            });

            if (opinion.like) {
                opinion.like = 0;
                opinion.likes_count--;
            } else {
                opinion.like = 1;
                opinion.likes_count++;
            }
        },
    },
};
</script>