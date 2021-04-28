<template>
    <div
        class="flex flex-col justify-center items-center mx-auto p-3 pt-5 mt-2 mb-6 shadow w-full sm:rounded-md bg-white dark:text-white dark:bg-gray-800"
    >
        <div class="flex justify-center flex-col mb-3 w-full">
            <div class="mr-5 flex flex-col items-center">
                <img
                    class="w-32 h-32 rounded-full mx-2 container object-cover shadow"
                    :src="user.profile_photo_url"
                />
            </div>

            <div class="flex justify-between w-full pb-2 mb-2">
                <div>
                    <div class="font-bold text-lg" v-text="user.name"></div>

                    <div
                        class="font-medium text-base text-gray-500"
                        v-text="user.username"
                    ></div>
                </div>

                <div v-if="!profile">
                    <user-card-follow :user="user"></user-card-follow>
                </div>

                <div v-else>
                    <inertia-link
                        :href="route('profile.show')"
                        class="text-sm rounded-md flex py-1 px-5 justify-center items-center bg-gray-300 dark:bg-gray-600"
                    >
                        Edit profile
                    </inertia-link>
                </div>
            </div>

            <div>
                <div
                    class="break-all pb-2"
                    v-if="user.bio"
                    v-text="user.bio"
                ></div>

                <div class="text-sm mb-2">
                    <a
                        :href="route('user.following', user)"
                        class="hover:text-blue-400"
                    >
                        <span class="text-blue-400">{{
                            user.following_count
                        }}</span>
                        <span>following ·</span>
                    </a>
                    <a
                        :href="route('user.followers', user)"
                        class="hover:text-blue-400"
                    >
                        <span class="text-blue-400">{{
                            user.followers_count
                        }}</span>
                        <span>followers</span>
                    </a>
                </div>

                <user-profile-info icon="location" v-if="user.location">
                    <span class="truncate">{{ user.location }}</span>
                </user-profile-info>

                <user-profile-info icon="link" v-if="user.website">
                    <a
                        class="text-blue-400 hover:underline truncate"
                        :href="user.website"
                        target="_blank"
                    >
                        {{ user.website }}
                    </a>
                </user-profile-info>

                <user-profile-info icon="calendar">
                    <span>Joined {{ user.created_at_human }}</span>
                </user-profile-info>
            </div>
        </div>
    </div>
</template>

<script>
import UserCardFollow from "@/Components/UserCardFollow";
import UserProfileInfo from "@/Components/UserProfileInfo";

export default {
    components: {
        UserCardFollow,
        UserProfileInfo,
    },

    props: {
        user: Object,
        profile: Boolean,
    },
};
</script>