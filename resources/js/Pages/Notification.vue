<template>
    <app-layout>
        <div class="mx-auto w-full">
            <div v-for="notification in notifications" :key="notification.id">
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
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import FollowNotification from "@/Components/FollowNotification";
import LikeNotification from "@/Components/LikeNotification";

export default {
    props: {
        notifications: null,
    },
    components: {
        AppLayout,
        OpinionCard,
        FollowNotification,
        LikeNotification,
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
