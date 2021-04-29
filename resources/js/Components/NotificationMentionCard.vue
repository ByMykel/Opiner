<template>
    <div
        :class="
            read ? 'bg-white dark:bg-gray-800' : 'bg-blue-100 dark:bg-gray-700'
        "
        class="w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md shadow sm:rounded-md dark:text-white"
    >
        <div class="flex justify-between">
            <div class="flex">
                <icons icon="mention" class="pr-2 text-blue-500"></icons>

                <a
                    :href="route('user', user)"
                    class="font-bold hover:underline pr-1"
                    v-text="user.name"
                >
                </a>
                <span>Mentioned you</span>
            </div>

            <notification-destroy-button
                :notification="notification"
            ></notification-destroy-button>
        </div>

        <div
            class="border border-gray-500 rounded-md p-2 m-2 break-all opinion-link"
        >
            <a :href="route('opinion', opinion.id)" v-html="opinion.opinion">
            </a>
        </div>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";
import NotificationDestroyButton from "@/Components/NotificationDestroyButton";

export default {
    components: {
        Icons,
        NotificationDestroyButton,
    },

    props: {
        notification: Object,
        user: null,
        opinion: null,
        read: null,
    },
};
</script>
