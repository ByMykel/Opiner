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

        <div class="pt-4 ml-2 dark:text-white">Followers</div>

        <user-card
            v-for="user in allFollowers.data"
            :key="user.id"
            :user="user"
        ></user-card>

        <info-message
            v-if="allFollowers.data.length === 0"
            text="No followers yet"
        ></info-message>

        <infinite-scroll
            v-if="allFollowers.data.length"
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
        InfiniteScroll,
        UserCard,
        InfoMessage,
    },

    props: {
        user: null,
        followers: null,
    },

    data() {
        return {
            allFollowers: this.followers,
        };
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
