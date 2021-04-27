<template>
    <div class="w-full flex">
        <input
            v-model="searchText"
            type="text"
            placeholder="Search people by username"
            class="w-full border-md my-4 pl-2 h-10 sm:rounded-l-md border-none shadow dark:text-white dark:bg-gray-800"
            @keyup.enter="search()"
        />

        <button
            class="flex bg-blue-400 w-24 h-10 my-4 justify-center items-center sm:rounded-r-md shadow"
            @click="search()"
        >
            <icons icon="search"></icons>
        </button>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

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

            this.$inertia.visit(route("explore", this.searchText.trim()));
        },
    },
};
</script>