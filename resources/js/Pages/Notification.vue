<template>
    <app-layout>
        <div v-for="notification in allNotifications.data" :key="notification.id">
            <div v-if="followNotification(notification.type)">
                <FollowNotification
                    :user="notification.data.user"
                    :read="notification.read_at"
                ></FollowNotification>
            </div>
            <div v-if="likeNotification(notification.type)">
                <LikeNotification
                    :user="notification.data.user"
                    :opinion="notification.data.opinion"
                    :read="notification.read_at"
                ></LikeNotification>
            </div>
        </div>
        <InfiniteScroll v-if="allNotifications.data.length" @scroll="scroll()" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import FollowNotification from "@/Components/FollowNotification";
import LikeNotification from "@/Components/LikeNotification";
import InfiniteScroll from "@/Components/InfiniteScroll";

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
        FollowNotification,
        LikeNotification,
        InfiniteScroll,
    },
    methods: {
        followNotification(type) {
            return type === "App\\Notifications\\FollowNotification";
        },
        likeNotification(type) {
            return type === "App\\Notifications\\LikeNotification";
        },
        scroll() {
            if (this.allNotifications.next_page_url === null) {
                return;
            }

            axios.get(this.allNotifications.next_page_url).then((response) => {
                this.allNotifications = {
                    ...response.data,
                    data: [...this.allNotifications.data, ...response.data.data],
                };
            });
        },
    },
};
</script>
