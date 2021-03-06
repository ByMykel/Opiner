<template>
    <app-layout>
        <user-search-bar></user-search-bar>

        <user-card
            v-for="user in allUsers.data"
            :key="user.id"
            :user="user"
        ></user-card>

        <info-message v-if="showMessage" :text="resultsMessage"></info-message>

        <infinite-scroll
            v-if="allUsers.data.length"
            @scroll="scroll()"
        ></infinite-scroll>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import InfiniteScroll from "@/Components/InfiniteScroll";
import UserSearchBar from "@/Components/UserSearchBar";
import InfoMessage from "@/Components/InfoMessage";
import UserCard from "@/Components/UserCard";

export default {
    components: {
        AppLayout,
        InfiniteScroll,
        UserSearchBar,
        InfoMessage,
        UserCard,
    },

    props: {
        users: null,
    },

    data() {
        return {
            allUsers: this.users,
        };
    },

    computed: {
        resultsMessage() {
            return `No results for "${this.$page.url
                .replace("/explore/", "")
                .replace(/%20/g, " ")}"`;
        },

        showMessage() {
            return (
                this.$page.url !== "/explore" &&
                this.$page.url !== "/explore/" &&
                this.allUsers.data.length == 0
            );
        },
    },

    mounted() {
        // Don't paginate in /explore
        if (this.$page.url === "/explore" || this.$page.url === "/explore/") {
            this.users.next_page_url = null;
        }
    },

    methods: {
        scroll() {
            if (this.allUsers.next_page_url === null) {
                return;
            }

            axios.get(this.allUsers.next_page_url).then((response) => {
                this.allUsers = {
                    ...response.data,
                    data: [...this.allUsers.data, ...response.data.data],
                };
            });
        },
    },
};
</script>
