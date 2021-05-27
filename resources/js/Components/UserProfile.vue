<template>
    <div
        class="flex flex-col justify-center items-center mx-auto p-3 pt-5 mt-2 mb-6 shadow w-full sm:rounded-md bg-white dark:text-white dark:bg-gray-900"
    >
        <div class="flex justify-center flex-col mb-3 w-full">
            <div class="mr-5 flex flex-col items-center">
                <img
                    :src="user.profile_photo_url"
                    class="w-32 h-32 rounded-full mx-2 container object-cover shadow"
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
                    <a
                        :href="route('profile.show')"
                        class="text-sm rounded-md flex py-1 px-5 justify-center items-center bg-gray-300 dark:bg-gray-600"
                    >
                        Edit profile
                    </a>
                </div>
            </div>

            <div>
                <div
                    v-if="user.bio"
                    class="break-all pb-2"
                    v-text="user.bio"
                ></div>

                <div class="text-sm mb-2">
                    <a
                        :href="route('user.following', user)"
                        class="hover:text-blue-400"
                    >
                        <span
                            class="text-blue-400"
                            v-text="user.following_count"
                        ></span>

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

                <user-profile-info v-if="user.location" icon="location">
                    <span class="truncate" v-text="user.location"></span>
                </user-profile-info>

                <user-profile-info v-if="user.website" icon="link">
                    <a
                        :href="user.website"
                        class="text-blue-400 hover:underline truncate"
                        target="_blank"
                        v-text="user.website"
                    >
                    </a>
                </user-profile-info>

                <user-profile-info icon="calendar">
                    <span v-text="joinedDate"></span>
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

    computed: {
        joinedDate() {
            return "Joined " + this.user.created_at_human;
        },
    },
};
</script>