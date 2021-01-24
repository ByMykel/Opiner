<template>
    <app-layout>
        <UserProfile :user="user[0]" :profile="profile" />
        <OpinionCard
            :opinion="opinion"
            :linkReplies="true"
            v-for="opinion in allOpinions.data"
            :key="opinion.id"
            :showOpinionReplayed="true"
        />
        <InfoMessage
            v-if="allOpinions.data.length === 0"
            text="No Opinions yet"
        />
        <InfiniteScroll v-if="allOpinions.data.length" @scroll="scroll()" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import InfiniteScroll from "@/Components/InfiniteScroll";
import InfoMessage from "@/Components/InfoMessage";
import UserProfile from "@/Components/UserProfile";

export default {
    props: {
        user: null,
        opinions: null,
        likes: null,
        profile: null,
    },
    data() {
        return {
            allOpinions: this.opinions,
        };
    },
    components: {
        AppLayout,
        OpinionCard,
        InfiniteScroll,
        InfoMessage,
        UserProfile,
    },
    methods: {
        scroll() {
            if (this.allOpinions.next_page_url === null) {
                return;
            }

            axios.get(this.allOpinions.next_page_url).then((response) => {
                this.allOpinions = {
                    ...response.data,
                    data: [...this.allOpinions.data, ...response.data.data],
                };
            });
        },
    },
};
</script>
