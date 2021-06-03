<template>
    <div
        class="flex flex-row w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md shadow sm:rounded-md bg-white dark:text-white dark:bg-gray-900"
    >
        <a :href="route('user', user)" class="h-10 w-10 m-1 mr-3 flex-shrink-0">
            <img
                :src="user.profile_photo_url"
                class="w-10 h-10 rounded-full container hover:opacity-80 flex-shrink-0 object-cover"
            />
        </a>

        <div class="w-full">
            <div class="flex justify-between">
                <div>
                    <a
                        :href="route('user', user)"
                        class="hover:underline font-bold"
                        v-text="user.name"
                    />

                    <div class="text-gray-500" v-text="user.username"></div>
                </div>

                <div v-if="notSameUser">
                    <user-card-follow :user="user"></user-card-follow>
                </div>
            </div>

            <div class="mt-1 break-all" v-text="user.bio"></div>

            <user-profile-info
                v-if="user.location"
                icon="location"
                class="pt-0.5"
            >
                <span
                    class="text-xs flex items-center break-all text-gray-600 dark:text-gray-400"
                    v-text="user.location"
                ></span>
            </user-profile-info>
        </div>
    </div>
</template>

<script>
import UserCardFollow from "@/Components/UserCardFollow";
import UserProfileInfo from "./UserProfileInfo";

export default {
    components: {
        UserCardFollow,
        UserProfileInfo,
    },

    props: {
        user: Object,
    },

    computed: {
        notSameUser() {
            return this.$page.props.auth.id !== this.user.id;
        },
    },
};
</script>