<template>
    <div @click="destroy(notification)">
        <Icons
            icon="trash"
            class="text-gray-400 hover:text-red-400 cursor-pointer"
        />
    </div>
</template>

<script>
import Icons from "@/Components/Icons";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        notification: Object,
    },
    components: {
        Icons,
    },
    methods: {
        destroy(notification) {
            Inertia.delete(route("notifications.delete", notification), {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },
    },
};
</script>