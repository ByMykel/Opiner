<template>
    <div>
        <div class="min-h-screen flex max-w-6xl mx-auto">
            <nav class="sm:pl-3 flex sm:block fixed p-1 sm:pt-20 bg-gray-100 sm:bg-transparent bottom-0 w-full sm:top-0 sm:w-min justify-around">
                <inertia-link class="w-auto" :href="route('home')" :class="{ 'text-blue-500' : route().current('home') }">
                    <div class="flex rounded-full p-1 my-1 hover:bg-blue-100">
                        <Icons icon="home" />
                        <span class="px-1 hidden md:block">Home</span>
                    </div>
                </inertia-link>
                <inertia-link :href="route('explore')" :class="{ 'text-blue-500' : route().current('explore') }">
                    <div class="flex rounded-full p-1 my-1 hover:bg-blue-100">
                        <Icons icon="search" />
                        <span class="px-1 hidden md:block">Explore</span>
                    </div>
                </inertia-link>
                <inertia-link :href="route('notifications')" :class="{ 'text-blue-500' : route().current('notifications') }">
                    <div class="flex rounded-full p-1 my-1 hover:bg-blue-100">
                        <Icons icon="bell" :class="{'animate-bounce' : $page.props.notifications_count}" />
                        <span class="px-1 hidden md:block">Notifications</span>
                    </div>
                </inertia-link>
                <inertia-link :href="route('user', $page.props.auth)" :class="{ 'text-blue-500' : route().current('user', $page.props.auth) }">
                    <div class="flex rounded-full p-1 my-1 hover:bg-blue-100">
                        <Icons icon="user" />
                        <span class="px-1 hidden md:block">Profile</span>
                    </div>
                </inertia-link>
                <inertia-link :href="route('profile.show')" :class="{ 'text-blue-500' : route().current('profile.show') }">
                    <div class="flex rounded-full p-1 my-1 hover:bg-blue-100">
                        <Icons icon="cog" />
                        <span class="px-1 hidden md:block">Settings</span>
                    </div>
                </inertia-link>
                <form @submit.prevent="logout">
                    <button type="submit">
                        <div class="flex rounded-full p-1 my-1 sm:pt-4 hover:text-blue-500">
                            <Icons icon="logout" />
                            <span class="px-1 hidden md:block">Log out</span>
                        </div>
                    </button>
                </form>
            </nav>

            <!-- Page Content -->
            <main class="sm:pl-6 pb-12 mx-auto w-full sm:w-4/6">
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
