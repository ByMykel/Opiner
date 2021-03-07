<template>
    <div
        class="w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md shadow sm:rounded-md bg-white"
        :class="{ 'bg-blue-100': !read }"
    >
        <div class="flex justify-between">
            <div class="flex">
                <Icons icon="user" class="pr-2 text-purple-500" />
                <inertia-link
                    :href="route('user', user)"
                    class="font-bold hover:underline pr-1"
                >
                    {{ user.name }}
                </inertia-link>
                Followed you
            </div>
            <NotificationDestroyButton :notification="notification" />
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
        read: null,
    },
    components: {
        Icons,
        NotificationDestroyButton
    },
};
</script>
