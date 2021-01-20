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
    </div>
</template>

<script>
import FollowNotification from "@/Components/FollowNotification";
import LikeNotification from "@/Components/LikeNotification";

export default {
    props: {
        notification: Object,
    },
    components: {
        FollowNotification,
        LikeNotification
    },
    methods: {
        followNotification(type) {
            return type === "App\\Notifications\\FollowNotification";
        },
        likeNotification(type) {
            return type === "App\\Notifications\\LikeNotification";
        },
    },
};
</script>