<template>
    <div>
        <div
            v-if="
                notification.type === 'App\\Notifications\\FollowNotification'
            "
        >
            <notification-follow-card
                :notification="notification"
                :user="notification.data.user"
                :read="notification.read_at"
            ></notification-follow-card>
        </div>

        <div
            v-else-if="
                notification.type === 'App\\Notifications\\LikeNotification'
            "
        >
            <notification-like-card
                :notification="notification"
                :user="notification.data.user"
                :opinion="notification.data.opinion"
                :read="notification.read_at"
            ></notification-like-card>
        </div>

        <div
            v-else-if="
                notification.type === 'App\\Notifications\\MentionNotification'
            "
        >
            <notification-mention-card
                :notification="notification"
                :user="notification.data.user"
                :opinion="notification.data.opinion"
                :read="notification.read_at"
            ></notification-mention-card>
        </div>

        <div
            v-else-if="
                notification.type === 'App\\Notifications\\ReopinionNotification'
            "
        >
            <notification-reopinion-card
                :notification="notification"
                :user="notification.data.user"
                :opinion="notification.data.opinion"
                :read="notification.read_at"
            ></notification-reopinion-card>
        </div>
    </div>
</template>

<script>
import NotificationFollowCard from "@/Components/NotificationFollowCard";
import NotificationLikeCard from "@/Components/NotificationLikeCard";
import NotificationMentionCard from "@/Components/NotificationMentionCard";
import NotificationReopinionCard from "@/Components/NotificationReopinionCard";

export default {
    components: {
        NotificationFollowCard,
        NotificationLikeCard,
        NotificationMentionCard,
        NotificationReopinionCard
    },

    props: {
        notification: Object,
    },
};
</script>