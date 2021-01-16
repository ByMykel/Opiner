<template>
    <app-layout>
        <div
            class="flex flex-col items-center mx-auto h-auto justify-center pt-10 p-1 mt-2 mb-12 text-black border border-gray-500 w-full rounded-md"
        >
            <div class="mx-auto p-4 w-full">
                <div class="flex justify-center flex-col sm:flex-row mb-3">
                    <div class="mr-5 flex flex-col items-center">
                        <img
                            class="w-24 h-24 rounded-full mx-2 container"
                            :src="user[0].profile_photo_url"
                            alt=""
                        />
                        <div v-if="!profile">
                            <FollowButton :user="user[0]" />
                        </div>
                    </div>
                    <div>
                        <div>{{ user[0].name }}</div>
                        <div class="text-blue-400">@{{ user[0].username }}</div>
                        <div class="flex" v-if="user[0].location">
                            <Icons icon="location" />
                            <span
                                class="pl-1 truncate w-48"
                                :title="user[0].location"
                            >
                                {{ user[0].location }}
                            </span>
                        </div>
                        <div class="flex" v-if="user[0].website">
                            <Icons icon="link" />
                            <inertia-link
                                class="pl-1 text-blue-400 hover:underline truncate w-48"
                                :href="user[0].website"
                            >
                                {{ user[0].website }}
                            </inertia-link>
                        </div>
                        <div class="flex">
                            <Icons icon="calendar" /><span class="pl-1"
                                >Joined {{ user[0].created_at_human }}</span
                            >
                        </div>
                    </div>
                </div>
                <div class="container break-all" v-if="user[0].bio">
                    {{ user[0].bio }}
                </div>
                <div class="flex justify-around p-1 text-center w-full pt-10">
                    <div>
                        <div>Opinions</div>
                        <div class="text-blue-400">
                            {{ user[0].opinions_count }}
                        </div>
                    </div>
                    <inertia-link :href="route('user.following', user)">
                        <div>Following</div>
                        <div class="text-blue-400">
                            {{ user[0].following_count }}
                        </div>
                    </inertia-link>
                    <inertia-link :href="route('user.followers', user)">
                        <div>Followers</div>
                        <div class="text-blue-400">
                            {{ user[0].followers_count }}
                        </div>
                    </inertia-link>
                </div>
            </div>
        </div>
        <OpinionCard
            :opinion="opinion"
            :linkReplies="true"
            v-for="opinion in opinions"
            :key="opinion.id"
            :showOpinionReplayed="true"
        />
        <div class="text-center" v-if="opinions.length == 0">
            No Opinions yet
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import Icons from "@/Components/Icons";
import FollowButton from "@/Components/FollowButton";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        user: null,
        opinions: null,
        likes: null,
        profile: null,
        hoverFollow: false,
    },
    data() {
        return {
            hover_follor: this.hoverFollow,
        };
    },
    components: {
        AppLayout,
        OpinionCard,
        Icons,
        FollowButton,
    },
};
</script>
