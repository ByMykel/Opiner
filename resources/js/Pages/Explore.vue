<template>
    <app-layout>
        <SearchBar />
        <UserCard v-for="user in allUsers.data" :key="user.id" :user="user" />
        <InfoMessage v-if="showMessage" :text="resultsMessage" />
        <InfiniteScroll v-if="allUsers.data.length" @scroll="scroll()" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import InfiniteScroll from "@/Components/InfiniteScroll";
import SearchBar from "../Components/SearchBar.vue";
import InfoMessage from "@/Components/InfoMessage";
import UserCard from "@/Components/UserCard";

export default {
    props: {
        users: null,
    },
    components: {
        AppLayout,
        InfiniteScroll,
        SearchBar,
        InfoMessage,
        UserCard,
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
