<template>
    <div>
        <div class="min-h-screen flex max-w-6xl mx-auto">
            <nav
                class="dark:text-white sm:pl-3 flex sm:block fixed p-1 sm:pt-20 bg-gray-200 dark:bg-gray-900 sm:bg-transparent bottom-0 w-full sm:top-0 sm:w-min justify-around z-50 border-t border-gray-300 dark:border-gray-800 sm:border-t-0"
            >
                <inertia-link class="w-auto" :href="route('home')">
                    <div
                        class="flex items-center rounded-full md:rounded-md p-1 my-1 hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300"
                        :class="{
                            'dark:bg-gray-800 bg-gray-200 text-gray-800': route().current(
                                'home'
                            ),
                        }"
                    >
                        <Icons icon="home" />

                        <span class="px-2 hidden md:block font-bold">Home</span>
                    </div>
                </inertia-link>

                <inertia-link :href="route('explore')">
                    <div
                        class="flex items-center rounded-full md:rounded-md p-1 my-1 hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300"
                        :class="{
                            'dark:bg-gray-800 bg-gray-200 text-gray-800': route().current(
                                'explore'
                            ),
                        }"
                    >
                        <Icons icon="search" />

                        <span class="px-2 hidden md:block font-bold"
                            >Explore</span
                        >
                    </div>
                </inertia-link>

                <inertia-link :href="route('notifications')">
                    <div
                        class="flex items-center rounded-full md:rounded-md p-1 my-1 hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300"
                        :class="{
                            'dark:bg-gray-800 bg-gray-200 text-gray-800': route().current(
                                'notifications'
                            ),
                        }"
                    >
                        <Icons
                            icon="bell"
                            :class="{
                                'animate-bounce':
                                    $page.props.notifications_count,
                            }"
                        />

                        <span class="px-2 hidden md:block font-bold"
                            >Notifications</span
                        >
                    </div>
                </inertia-link>

                <inertia-link :href="route('user', $page.props.auth)">
                    <div
                        class="flex items-center rounded-full md:rounded-md p-1 my-1 hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300"
                        :class="{
                            'dark:bg-gray-800 bg-gray-200 text-gray-800': route().current(
                                'user',
                                $page.props.auth
                            ),
                        }"
                    >
                        <Icons icon="user" />

                        <span class="px-2 hidden md:block font-bold"
                            >Profile</span
                        >
                    </div>
                </inertia-link>

                <inertia-link :href="route('profile.show')">
                    <div
                        class="flex items-center rounded-full md:rounded-md p-1 my-1 hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300"
                        :class="{
                            'dark:bg-gray-800 bg-gray-200 text-gray-800': route().current(
                                'profile.show'
                            ),
                        }"
                    >
                        <Icons icon="cog" />

                        <span class="px-2 hidden md:block font-bold"
                            >Settings</span
                        >
                    </div>
                </inertia-link>

                <form @submit.prevent="logout">
                    <button type="submit" class="sm:mt-4">
                        <div
                            class="flex items-center rounded-md p-1 my-1 text-red-500 hover:text-red-300"
                        >
                            <Icons icon="logout" />

                            <span class="px-2 hidden md:block font-bold"
                                >Log out</span
                            >
                        </div>
                    </button>
                </form>
            </nav>

            <!-- Page Content -->
            <main class="md:pl-6 pb-12 mx-auto w-full sm:w-4/6">
                <slot></slot>
            </main>

            <!-- Modal Portal -->
            <portal-target name="modal" multiple> </portal-target>
        </div>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

export default {
    components: {
        Icons,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },

    methods: {
        logout() {
            this.$inertia.post(route("logout"));
        },
    },
};
</script>
