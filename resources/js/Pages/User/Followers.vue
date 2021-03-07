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
        <div class="pt-4 ml-2">Followers</div>
        <UserCard
            v-for="user in allFollowers.data"
            :key="user.id"
            :user="user"
        />
        <InfoMessage
            v-if="allFollowers.data.length === 0"
            text="No followers yet"
        />
        <InfiniteScroll v-if="allFollowers.data.length" @scroll="scroll()" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import InfiniteScroll from "@/Components/InfiniteScroll";
import UserCard from "@/Components/UserCard";
import Icons from "@/Components/Icons";
import InfoMessage from "@/Components/InfoMessage";

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
        InfoMessage,
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
