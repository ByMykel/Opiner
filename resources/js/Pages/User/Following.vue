<template>
    <app-layout>
        <a :href="route('user', user)" class="flex p-2">
            <div class="pr-5 p-3 dark:text-white">
                <icons icon="arrow-left"></icons>
            </div>

            <div>
                <div
                    class="font-semibold dark:text-white"
                    v-text="user.name"
                ></div>

                <div class="text-blue-400" v-text="user.username"></div>
            </div>
        </a>

        <div class="pt-4 ml-2 dark:text-white">Following</div>

        <user-card
            v-for="user in allFollowing.data"
            :key="user.id"
            :user="user"
        ></user-card>

        <info-message
            v-if="allFollowing.data.length === 0"
            text="No following yet"
        ></info-message>

        <infinite-scroll
            v-if="allFollowing.data.length"
            @scroll="scroll()"
        ></infinite-scroll>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import InfiniteScroll from "@/Components/InfiniteScroll";
import UserCard from "@/Components/UserCard";
import Icons from "@/Components/Icons";
import InfoMessage from "@/Components/InfoMessage";

export default {
    components: {
        AppLayout,
        Icons,
        UserCard,
        InfiniteScroll,
        InfoMessage,
    },

    props: {
        user: null,
        following: null,
    },

    data() {
        return {
            allFollowing: this.following,
        };
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
