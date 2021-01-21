<template>
    <div
        class="w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md border border-gray-500 rounded-md"
        :class="{ 'bg-blue-100': !read }"
    >
        <div class="flex">
            <Icons icon="heart-solid" class="pr-2 text-red-500" />
            <inertia-link
                :href="route('user', user)"
                class="font-bold hover:underline pr-1"
            >
                {{ user.name }}
            </inertia-link>
            Liked your Opinion
        </div>
        <div class="border border-gray-500 rounded-md p-2 m-2 break-all">
            <inertia-link :href="route('opinion', opinion.id)">
                {{ opinion.opinion }}
            </inertia-link>
        </div>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

export default {
    props: {
        user: null,
        opinion: null,
        read: null,
    },
    components: {
        Icons,
    },
};
</script>
