<template>
    <app-layout>
        <SearchBar />
        <div v-if="allUsers.data.length > 0">
            <div
                v-for="user in allUsers.data"
                :key="user.id"
                class="flex flex-row w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md border border-gray-500 rounded-md"
            >
                <inertia-link
                    :href="route('user', user)"
                    class="hover:underline font-bold hover:opacity-80"
                >
                    <img
                        :src="user.profile_photo_url"
                        class="h-10 w-10 mr-4 rounded-full container"
                    />
                </inertia-link>
                <div class="w-full">
                    <inertia-link
                        :href="route('user', user)"
                        class="hover:underline font-bold"
                    >
                        {{ user.name }}
                    </inertia-link>
                    <div class="text-blue-400">@{{ user.username }}</div>
                    <div class="mt-1 break-all">
                        {{ user.bio }}
                    </div>
                </div>
            </div>
        </div>
        <InfoMessage v-if="showMessage" :text="resultsMessage" />
        <InfiniteScroll v-if="allUsers.data.length" @scroll="scroll()" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import InfiniteScroll from "@/Components/InfiniteScroll";
import { Inertia } from "@inertiajs/inertia";
import SearchBar from "../Components/SearchBar.vue";
import InfoMessage from "@/Components/InfoMessage";

export default {
    props: {
        users: null,
    },
    components: {
        AppLayout,
        InfiniteScroll,
        SearchBar,
        InfoMessage,
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
