<template>
    <div @click="destroy(notification)">
        <icons
            icon="trash"
            class="text-gray-400 hover:text-red-400 cursor-pointer"
        ></icons>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

export default {
    components: {
        Icons,
    },

    props: {
        notification: Object,
    },

    methods: {
        destroy(notification) {
            this.$inertia.delete(route("notifications.delete", notification), {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },
    },
};
</script>