<template>
    <div>
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
        <div v-if="mentionNotification(notification.type)">
            <MentionNotification
                :user="notification.data.user"
                :opinion="notification.data.opinion"
                :read="notification.read_at"
            ></MentionNotification>
        </div>
    </div>
</template>

<script>
import FollowNotification from "@/Components/FollowNotification";
import LikeNotification from "@/Components/LikeNotification";
import MentionNotification from "@/Components/MentionNotification";

export default {
    props: {
        notification: Object,
    },
    components: {
        FollowNotification,
        LikeNotification,
        MentionNotification
    },
    methods: {
        followNotification(type) {
            return type === "App\\Notifications\\FollowNotification";
        },
        likeNotification(type) {
            return type === "App\\Notifications\\LikeNotification";
        },
        mentionNotification(type) {
            return type === "App\\Notifications\\MentionNotification";
        },
    },
};
</script>