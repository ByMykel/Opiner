<template>
    <div
        class="w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md shadow sm:rounded-md dark:text-white"
        :class="
            read ? 'bg-white dark:bg-gray-800' : 'bg-blue-100 dark:bg-gray-700'
        "
    >
        <div class="flex justify-between">
            <div class="flex">
                <Icons icon="heart-solid" class="pr-2 text-red-500" />
                <inertia-link
                    :href="route('user', user)"
                    class="font-bold hover:underline pr-1"
                >
                    {{ user.name }}
                </inertia-link>
                Liked your opinion
            </div>
            <NotificationDestroyButton :notification="notification" />
        </div>
        <div
            class="border border-gray-500 rounded-md p-2 m-2 break-all opinion-link"
        >
            <inertia-link
                :href="route('opinion', opinion.id)"
                v-html="opinion.opinion"
            >
            </inertia-link>
        </div>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";
import NotificationDestroyButton from "@/Components/NotificationDestroyButton";

export default {
    props: {
        notification: Object,
        user: null,
        opinion: null,
        read: null,
    },
    components: {
        Icons,
        NotificationDestroyButton,
    },
};
</script>
