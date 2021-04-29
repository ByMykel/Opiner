<template>
    <div
        :class="{ 'text-red-500': opinion.like }"
        class="cursor-pointer flex hover:text-red-400"
        @click="handleLike()"
    >
        <icons v-if="opinion.like" icon="heart-solid"></icons>

        <icons v-else icon="heart"></icons>

        <span
            class="pl-1 flex items-center"
            v-text="opinion.likes_count"
        ></span>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

export default {
    components: {
        Icons,
    },

    props: {
        opinion: Object,
    },

    methods: {
        handleLike() {
            this.$inertia.post(route("opinion.like", this.opinion.id), [], {
                preserveState: true,
                preserveScroll: true,
                resetOnSuccess: false,
            });

            this.opinion.likes_count += this.opinion.like ? -1 : 1;
            this.opinion.like = !this.opinion.like;
        },
    },
};
</script>