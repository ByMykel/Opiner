<template>
    <button
        @click="follow(user)"
        class="w-8 h-8 rounded-full my-2 flex justify-center items-center"
        :class="[
            user.follow
                ? 'hover:bg-red-400 bg-green-400'
                : 'bg-none border-2 border-black dark:border-white hover:bg-green-400',
        ]"
        @mouseover="hoverButton = true"
        @mouseleave="hoverButton = false"
    >
        <span v-if="user.follow">
            <Icons v-if="user.follow && !hoverButton" icon="check" />
            <Icons v-else icon="x" />
        </span>
        <span v-else>
            <Icons icon="plus" />
        </span>
    </button>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import Icons from "@/Components/Icons";

export default {
    props: {
        user: null,
    },
    data() {
        return {
            hoverButton: false,
        };
    },
    components: {
        Icons,
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
