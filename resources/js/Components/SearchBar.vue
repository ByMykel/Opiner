<template>
    <div class="w-full flex">
        <input
            v-model="searchText"
            type="text"
            class="w-full border-md my-4 pl-2 h-10 sm:rounded-l-md border-none shadow"
            placeholder="Search people by username"
            @keyup.enter="search()"
        />
        <button
            class="flex bg-blue-400 w-24 h-10 my-4 justify-center items-center sm:rounded-r-md shadow"
            @click="search()"
        >
            <Icons icon="search" />
        </button>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";
import { Inertia } from "@inertiajs/inertia";

export default {
    data() {
        return {
            searchText: "",
        };
    },
    components: {
        Icons,
    },
    methods: {
        search() {
            if (!this.searchText.trim()) {
                return;
            }

            Inertia.visit(route("explore", this.searchText.trim()));
        },
    },
};
</script>