<template>
    <div
        class="flex flex-row w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md shadow sm:rounded-md bg-white dark:text-white dark:bg-gray-800"
    >
        <img
            :src="user.profile_photo_url"
            class="h-10 w-10 mr-4 rounded-full"
        />

        <div class="w-full">
            <div class="flex justify-between">
                <div>
                    <a
                        :href="route('user', user)"
                        class="hover:underline font-bold"
                        v-text="user.name"
                    />

                    <div class="text-gray-500" v-text="user.username"></div>
                </div>

                <div v-if="notSameUser">
                    <user-card-follow :user="user"></user-card-follow>
                </div>
            </div>

            <div class="mt-1 break-all" v-text="user.bio"></div>
        </div>
    </div>
</template>

<script>
import UserCardFollow from "@/Components/UserCardFollow";

export default {
    components: {
        UserCardFollow,
    },

    props: {
        user: Object,
    },

    computed: {
        notSameUser() {
            return this.$page.props.auth.id !== this.user.id
        }
    }
};
</script>