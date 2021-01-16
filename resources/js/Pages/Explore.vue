<template>
    <app-layout>
        <div class="w-full flex">
            <input
                v-model="searchText"
                type="text"
                class="w-full border-md my-4 pl-2 h-10 rounded-l-md"
                placeholder="Search people by username"
                @keyup.enter="search()"
            />
            <button
                class="flex bg-blue-400 w-24 h-10 my-4 justify-center items-center rounded-r-md"
                @click="search()"
            >
                <Icons icon="search" />
            </button>
        </div>
        <div v-if="users.length > 0">
            <div
                v-for="user in users"
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
        <div v-else class="w-full text-center text-md">
            <div v-if="$page.url.replace('/explore/', '')">
                No results for "{{ $page.url.replace("/explore/", "") }}"
            </div>
            <div v-else>No results</div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Icons from "@/Components/Icons";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        users: null,
    },
    components: {
        AppLayout,
        Icons,
    },
    data() {
        return {
            searchText: "",
        };
    },
    methods: {
        search() {
            if (!this.searchText) {
                return;
            }

            Inertia.visit(route("explore", this.searchText));
        },
    },
};
</script>
