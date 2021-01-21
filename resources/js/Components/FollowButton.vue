<template>
    <button
        @click="follow(user)"
        class="w-24 h-8 rounded-full my-2"
        :class="[
            user.follow
                ? 'hover:bg-red-400 bg-blue-400'
                : 'bg-none border-2 border-blue-400 hover:bg-blue-200',
        ]"
        @mouseover="hoverButton = true"
        @mouseleave="hoverButton = false"
    >
        <span v-if="user.follow">
            {{ user.follow && !hoverButton ? "Following" : "Unfollow" }}
        </span>
        <span v-else>Follow</span>
    </button>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

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
        follow(user) {
            Inertia.post(route("user.follow", user), [], {
                preserveScroll: true,
                resetOnSuccess: false,
            });

            user.follow = !user.follow;
        },
    },
};
</script>
