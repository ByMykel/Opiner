<template>
    <div>
        <div class="min-h-screen flex max-w-6xl mx-auto">
            <nav class="sm:pl-3 flex sm:block fixed p-1 sm:pt-20 bg-gray-200 sm:bg-transparent bottom-0 w-full sm:top-0 sm:w-min justify-around z-50 border-t border-gray-300 sm:border-t-0">
                <inertia-link class="w-auto" :href="route('home')">
                    <div class="flex rounded-full md:rounded-md p-1 my-1 hover:bg-gray-50" :class="{ 'bg-gray-50' : route().current('home') }">
                        <Icons icon="home" />
                        <span class="px-1 hidden md:block">Home</span>
                    </div>
                </inertia-link>
                <inertia-link :href="route('explore')">
                    <div class="flex rounded-full md:rounded-md p-1 my-1 hover:bg-gray-50" :class="{ 'bg-gray-50' : route().current('explore') }">
                        <Icons icon="search" />
                        <span class="px-1 hidden md:block">Explore</span>
                    </div>
                </inertia-link>
                <inertia-link :href="route('notifications')">
                    <div class="flex rounded-full md:rounded-md p-1 my-1 hover:bg-gray-50" :class="{ 'bg-gray-50' : route().current('notifications') }">
                        <Icons icon="bell" :class="{'animate-bounce' : $page.props.notifications_count}" />
                        <span class="px-1 hidden md:block">Notifications</span>
                    </div>
                </inertia-link>
                <inertia-link :href="route('user', $page.props.auth)">
                    <div class="flex rounded-full md:rounded-md p-1 my-1 hover:bg-gray-50" :class="{ 'bg-gray-50' : route().current('user', $page.props.auth) }">
                        <Icons icon="user" />
                        <span class="px-1 hidden md:block">Profile</span>
                    </div>
                </inertia-link>
                <inertia-link :href="route('profile.show')">
                    <div class="flex rounded-full md:rounded-md p-1 my-1 hover:bg-gray-50" :class="{ 'bg-gray-50' : route().current('profile.show') }">
                        <Icons icon="cog" />
                        <span class="px-1 hidden md:block">Settings</span>
                    </div>
                </inertia-link>
                <form @submit.prevent="logout">
                    <button type="submit" class="sm:mt-4">
                        <div class="flex rounded-md p-1 my-1 text-red-500 hover:text-red-300">
                            <Icons icon="logout" />
                            <span class="px-1 hidden md:block">Log out</span>
                        </div>
                    </button>
                </form>
            </nav>

            <!-- Page Content -->
            <main class="md:pl-6 pb-12 mx-auto w-full sm:w-4/6">
                <slot></slot>
            </main>

            <!-- Modal Portal -->
            <portal-target name="modal" multiple>
            </portal-target>
        </div>
    </div>
</template>

<script>
    import Icons from '@/Components/Icons';

    export default {
        components: {
            Icons,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
