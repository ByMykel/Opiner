<template>
    <div
        class="flex flex-col items-center mx-auto h-auto justify-center pt-10 p-1 mt-2 mb-12 text-black border border-gray-500 w-full rounded-md"
    >
        <div class="mx-auto p-4 w-full">
            <div class="flex justify-center flex-col sm:flex-row mb-3">
                <div class="mr-5 flex flex-col items-center">
                    <img
                        class="w-24 h-24 rounded-full mx-2 container object-cover"
                        :src="user.profile_photo_url"
                        alt=""
                    />
                    <div v-if="!profile">
                        <FollowButton :user="user" />
                    </div>
                </div>
                <div>
                    <div>{{ user.name }}</div>
                    <div class="text-blue-400">@{{ user.username }}</div>
                    <div class="flex" v-if="user.location">
                        <Icons icon="location" />
                        <span class="pl-1 truncate w-48" :title="user.location">
                            {{ user.location }}
                        </span>
                    </div>
                    <div class="flex" v-if="user.website">
                        <Icons icon="link" />
                        <a
                            class="pl-1 text-blue-400 hover:underline truncate w-48"
                            :href="user.website"
                            target="_blank"
                        >
                            {{ user.website }}
                        </a>
                    </div>
                    <div class="flex">
                        <Icons icon="calendar" /><span class="pl-1"
                            >Joined {{ user.created_at_human }}</span
                        >
                    </div>
                </div>
            </div>
            <div class="container break-all" v-if="user.bio">
                {{ user.bio }}
            </div>
            <div class="flex justify-around p-1 text-center w-full pt-10">
                <div>
                    <div>Opinions</div>
                    <div class="text-blue-400">
                        {{ user.opinions_count }}
                    </div>
                </div>
                <inertia-link :href="route('user.following', user)">
                    <div>Following</div>
                    <div class="text-blue-400">
                        {{ user.following_count }}
                    </div>
                </inertia-link>
                <inertia-link :href="route('user.followers', user)">
                    <div>Followers</div>
                    <div class="text-blue-400">
                        {{ user.followers_count }}
                    </div>
                </inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
import FollowButton from "@/Components/FollowButton";
import Icons from "@/Components/Icons";

export default {
    props: {
        user: Object,
        profile: Boolean,
    },
    components: {
        FollowButton,
        Icons,
    },
};
</script>