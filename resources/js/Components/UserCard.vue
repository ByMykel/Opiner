<template>
    <div
        class="flex flex-row w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md shadow rounded-md bg-white"
    >
        <img
            :src="user.profile_photo_url"
            class="h-10 w-10 mr-4 rounded-full"
        />
        <div class="w-full">
            <div class="flex justify-between">
                <div>
                    <inertia-link
                        :href="route('user', user)"
                        class="hover:underline font-bold"
                    >
                        {{ user.name }}
                    </inertia-link>
                    <div class="text-blue-400">@{{ user.username }}</div>
                </div>
                <div v-if="$page.props.auth.id !== user.id">
                    <FollowButton :user="user" />
                </div>
            </div>
            <div class="mt-1 break-all">
                {{ user.bio }}
            </div>
        </div>
    </div>
</template>

<script>
import FollowButton from "@/Components/FollowButton";

export default {
    props: {
        user: Object,
    },
    components: {
        FollowButton,
    },
};
</script>