<template>
    <app-layout>
        <opinion-create
            :parent="null"
            placeholder="What's happening?"
        ></opinion-create>

        <opinion-card
            v-for="(opinion, index) in opinions.data"
            :key="index"
            :opinion="opinion"
            :linkReplies="true"
            :showOpinionReplayed="true"
        ></opinion-card>

        <info-message
            v-if="timeline.data.length == 0"
            text="No Opinions yet"
        ></info-message>

        <infinite-scroll
            v-if="opinions.data.length"
            @scroll="scroll()"
        ></infinite-scroll>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import OpinionCreate from "@/Components/OpinionCreate";
import InfiniteScroll from "@/Components/InfiniteScroll";
import InfoMessage from "@/Components/InfoMessage";

export default {
    components: {
        AppLayout,
        OpinionCard,
        OpinionCreate,
        InfiniteScroll,
        InfoMessage,
    },

    props: {
        timeline: null,
    },

    data() {
        return {
            opinions: this.timeline,
        };
    },

    methods: {
        scroll() {
            if (!this.opinions.next_page_url) {
                return;
            }

            axios.get((route('home') + this.opinions.next_page_url)).then((response) => {
                this.opinions = {
                    ...response.data,
                    data: [...this.opinions.data, ...response.data.data],
                };
            });
        },
    },
};
</script>
