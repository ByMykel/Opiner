<template>
    <app-layout>
        <NotificationHandler
            v-for="notification in allNotifications.data"
            :key="notification.id"
            :notification="notification"
        />
        <InfoMessage
            v-if="notifications.data.length == 0"
            text="No notifications yet"
        />
        <InfiniteScroll
            v-if="allNotifications.data.length"
            @scroll="scroll()"
        />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import InfiniteScroll from "@/Components/InfiniteScroll";
import InfoMessage from "@/Components/InfoMessage";
import NotificationHandler from "@/Components/NotificationHandler";

export default {
    props: {
        notifications: null,
    },
    data() {
        return {
            allNotifications: this.notifications,
        };
    },
    components: {
        AppLayout,
        OpinionCard,
        InfiniteScroll,
        InfoMessage,
        NotificationHandler,
    },
    methods: {
        scroll() {
            if (this.allNotifications.next_page_url === null) {
                return;
            }

            axios.get(this.allNotifications.next_page_url).then((response) => {
                this.allNotifications = {
                    ...response.data,
                    data: [
                        ...this.allNotifications.data,
                        ...response.data.data,
                    ],
                };
            });
        },
    },
};
</script>
