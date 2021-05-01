<template>
    <div
        :class="{ 'text-green-500': opinion.reopinion }"
        class="cursor-pointer flex hover:text-green-400"
        @click="handleLike()"
    >
        <icons icon="refresh"></icons>

        <span
            class="pl-1 flex items-center"
            v-text="opinion.reopinions_count"
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
            this.$inertia.post(route("opinion.reopinion", this.opinion.id), [], {
                preserveState: true,
                preserveScroll: true,
                resetOnSuccess: false,
            });

            this.opinion.reopinions_count += this.opinion.reopinion ? -1 : 1;
            this.opinion.reopinion = !this.opinion.reopinion;
        },
    },
};
</script>