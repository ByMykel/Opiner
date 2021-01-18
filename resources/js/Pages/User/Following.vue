<template>
    <app-layout>
        <inertia-link :href="route('user', user)" class="flex p-2">
            <div class="pr-5 p-3">
                <Icons icon="arrow-left" />
            </div>
            <div>
                <div class="font-semibold">{{ user.name }}</div>
                <div class="text-blue-400">@{{ user.username }}</div>
            </div>
        </inertia-link>
        <div class="pt-4" v-if="allFollowing.data.length > 0">Following</div>
        <div class="text-center" v-else>No results</div>
        <div
            v-for="user in allFollowing.data"
            :key="user.id"
            class="flex flex-row w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md border border-gray-500 rounded-md"
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
                <div class="mt-1">
                    {{ user.bio }}
                </div>
            </div>
        </div>
        <InfiniteScroll v-if="allFollowing.data.length" @scroll="scroll()" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import { Inertia } from "@inertiajs/inertia";
import FollowButton from "../../Components/FollowButton";
import InfiniteScroll from "@/Components/InfiniteScroll";
import Icons from "@/Components/Icons";

export default {
    props: {
        user: null,
        following: null,
    },
    data() {
        return {
            allFollowing: this.following,
        };
    },
    components: {
        AppLayout,
        FollowButton,
        Icons,
        InfiniteScroll,
    },
    methods: {
        scroll() {
            if (this.allFollowing.next_page_url === null) {
                return;
            }

            axios.get(this.allFollowing.next_page_url).then((response) => {
                this.allFollowing = {
                    ...response.data,
                    data: [...this.allFollowing.data, ...response.data.data],
                };
            });
        },
    },
};
</script>
