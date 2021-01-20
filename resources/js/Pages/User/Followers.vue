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
        <div class="pt-4" v-if="allFollowers.data.length > 0">Followers</div>
        <div class="text-center" v-else>No results</div>
        <UserCard
            v-for="user in allFollowers.data"
            :key="user.id"
            :user="user"
        />
        <InfiniteScroll v-if="allFollowers.data.length" @scroll="scroll()" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import { Inertia } from "@inertiajs/inertia";
import InfiniteScroll from "@/Components/InfiniteScroll";
import UserCard from "@/Components/UserCard";
import Icons from "@/Components/Icons";

export default {
    props: {
        user: null,
        followers: null,
    },
    data() {
        return {
            allFollowers: this.followers,
        };
    },
    components: {
        AppLayout,
        Icons,
        InfiniteScroll,
        UserCard,
    },
    methods: {
        scroll() {
            if (this.allFollowers.next_page_url === null) {
                return;
            }

            axios.get(this.allFollowers.next_page_url).then((response) => {
                this.allFollowers = {
                    ...response.data,
                    data: [...this.allFollowers.data, ...response.data.data],
                };
            });
        },
    },
};
</script>
