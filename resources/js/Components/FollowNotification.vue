<template>
    <div
        class="flex w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md shadow rounded-md bg-white"
        :class="{ 'bg-blue-100': !read }"
    >
        <Icons icon="user" class="pr-2 text-purple-500" />
        <inertia-link
            :href="route('user', user)"
            class="font-bold hover:underline pr-1"
        >
            {{ user.name }}
        </inertia-link>
        Followed you
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

export default {
    props: {
        user: null,
        read: null,
    },
    components: {
        Icons,
    },
};
</script>
