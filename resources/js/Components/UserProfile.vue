<template>
    <div
        class="flex flex-col justify-center items-center mx-auto p-3 pt-5 mt-2 mb-12 border border-gray-500 w-full rounded-md"
    >
        <div class="flex justify-center flex-col mb-3 w-full">
            <div class="mr-5 flex flex-col items-center">
                <img
                    class="w-32 h-32 rounded-full mx-2 container object-cover shadow"
                    :src="user.profile_photo_url"
                />
            </div>
            <div
                class="flex justify-between w-full pb-2 border-b mb-2 border-gray-200"
            >
                <div>
                    <div class="font-bold">{{ user.name }}</div>
                    <div class="font-bold text-blue-400">
                        @{{ user.username }}
                    </div>
                </div>
                <FollowButton v-if="!profile" :user="user" />
                <inertia-link
                    :href="route('profile.show')"
                    v-else
                    class="flex justify-center items-center w-24 h-8 rounded-full my-2 bg-none border-2 border-blue-400 hover:bg-blue-200"
                >
                    Edit profile
                </inertia-link>
            </div>
            <div>
                <div class="break-all pb-2" v-if="user.bio">
                    {{ user.bio }}
                </div>
                <UserProfileInfo icon="location" v-if="user.location">
                    <span class="truncate">{{ user.location }}</span>
                </UserProfileInfo>
                <UserProfileInfo icon="link" v-if="user.website">
                    <a
                        class="text-blue-400 hover:underline truncate"
                        :href="user.website"
                        target="_blank"
                    >
                        {{ user.website }}
                    </a>
                </UserProfileInfo>
                <UserProfileInfo icon="calendar">
                    <span>Joined {{ user.created_at_human }}</span>
                </UserProfileInfo>
            </div>
        </div>
        <div class="flex justify-around p-1 text-center w-full pt-5">
            <inertia-link :href="route('user.following', user)">
                <div>Following</div>
                <div class="text-blue-400 font-bold">
                    {{ user.following_count }}
                </div>
            </inertia-link>
            <inertia-link :href="route('user.followers', user)">
                <div>Followers</div>
                <div class="text-blue-400 font-bold">
                    {{ user.followers_count }}
                </div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import FollowButton from "@/Components/FollowButton";
import UserProfileInfo from "@/Components/UserProfileInfo";

export default {
    props: {
        user: Object,
        profile: Boolean,
    },
    components: {
        FollowButton,
        UserProfileInfo,
    },
};
</script>