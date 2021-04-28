<template>
    <button
        :class="[
            user.follow
                ? 'hover:bg-red-300 bg-green-300'
                : 'bg-gray-300 dark:bg-gray-600 dark:text-gray-100 hover:bg-green-300 hover:border-green-400',
        ]"
        class="rounded-md flex py-1 px-5 justify-center items-center outline-none text-sm dark:text-black focus:outline-none focus:ring focus:border-blue-400"
        @click="handleFollow"
        @mouseover="hoverButton = true"
        @mouseleave="hoverButton = false"
    >
        <span v-if="user.follow">
            <span v-if="user.follow && !hoverButton">Following</span>
            <span v-else>Unfollow</span>
        </span>

        <span v-else>Follow</span>
    </button>
</template>

<script>
export default {
    props: {
        user: null,
    },

    data() {
        return {
            hoverButton: false,
        };
    },

    methods: {
        handleFollow() {
            this.$inertia.post(route("user.follow", this.user), [], {
                preserveState: true,
                preserveScroll: true,
                resetOnSuccess: false,
            });

            this.user.follow = !this.user.follow;
        },
    },
};
</script>
