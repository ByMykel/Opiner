<template>
    <app-layout>
        <OpinionCreate :parent="null" placeholder="What's happening?" />
        <OpinionCard
            :opinion="opinion"
            :linkReplies="true"
            v-for="opinion in opinions.data"
            :key="opinion.id"
            :showOpinionReplayed="true"
        />
        <div class="text-center pt-10" v-if="opinions.data.length == 0">
            No Opinions yet
        </div>
        <InfiniteScroll v-if="opinions.data.length" @scroll="scroll()" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import OpinionCreate from "@/Components/OpinionCreate";
import InfiniteScroll from "@/Components/InfiniteScroll";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        timeline: null,
    },
    data() {
        return {
            opinions: this.timeline,
        };
    },
    components: {
        AppLayout,
        OpinionCard,
        OpinionCreate,
        InfiniteScroll,
    },
    mounted() {
        this.scroll();
    },
    methods: {
        like(opinion) {
            Inertia.post(route("opinion.like", opinion.id), [], {
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },
        scroll() {
            if (!this.opinions.next_page_url) {
                return;
            }

            axios.get(this.opinions.next_page_url).then((response) => {
                this.opinions = {
                    ...response.data,
                    data: [...this.opinions.data, ...response.data.data],
                };
            });
        },
    },
};
</script>
