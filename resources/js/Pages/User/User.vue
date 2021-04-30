<template>
    <app-layout>
        <user-profile :user="user[0]" :profile="authUserProfile"></user-profile>

        <opinion-card
            v-for="opinion in allOpinions.data"
            :key="opinion.id"
            :opinion="opinion"
            :linkReplies="true"
            :showOpinionReplayed="true"
        ></opinion-card>

        <info-message
            v-if="allOpinions.data.length === 0"
            text="No Opinions yet"
        ></info-message>

        <infinite-scroll
            v-if="allOpinions.data.length"
            @scroll="scroll()"
        ></infinite-scroll>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import InfiniteScroll from "@/Components/InfiniteScroll";
import InfoMessage from "@/Components/InfoMessage";
import UserProfile from "@/Components/UserProfile";

export default {
    components: {
        AppLayout,
        OpinionCard,
        InfiniteScroll,
        InfoMessage,
        UserProfile,
    },

    props: {
        user: null,
        opinions: null,
        likes: null,
    },

    data() {
        return {
            allOpinions: this.opinions,
        };
    },

    computed: {
        authUserProfile() {
            return this.user[0].id === this.$page.props.auth.id;
        },
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
