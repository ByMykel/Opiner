<template>
    <div @click="handleDestroy()">
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
        handleDestroy() {
            this.$inertia.delete(
                route("notifications.delete", this.notification),
                {
                    preserveState: false,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },
    },
};
</script>