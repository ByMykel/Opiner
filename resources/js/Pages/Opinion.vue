<template>
    <app-layout>
        <a
            v-if="opinion.parent_id"
            :href="route('opinion', opinion.parent_id)"
            class="flex py-4 p-4 dark:text-white"
        >
            <icons icon="arrow-left" class="pr-5"></icons>

            <div class="font-semibold">
                Replying to
                <span
                    class="text-blue-400"
                    v-text="opinion.parent.user.username"
                >
                </span>
            </div>
        </a>

        <opinion-card :opinion="opinion"></opinion-card>

        <opinion-create
            :parent="opinion.id"
            class="mt-10"
            placeholder="Type your reply"
        ></opinion-create>

        <opinion-card
            v-for="opinion in allReplies.data"
            :key="opinion.id"
            :opinion="opinion"
            linkReplies
        ></opinion-card>

        <infinite-scroll
            v-if="allReplies.data.length"
            @scroll="scroll()"
        ></infinite-scroll>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import OpinionCreate from "@/Components/OpinionCreate";
import Icons from "@/Components/Icons";
import InfiniteScroll from "@/Components/InfiniteScroll";

export default {
    components: {
        AppLayout,
        OpinionCard,
        OpinionCreate,
        Icons,
        InfiniteScroll,
    },

    props: {
        user: null,
        opinion: null,
        replies: null,
    },

    data() {
        return {
            allReplies: this.replies,
        };
    },

    methods: {
        scroll() {
            if (this.allReplies.next_page_url === null) {
                return;
            }

            axios.get(this.allReplies.next_page_url).then((response) => {
                this.allReplies = {
                    ...response.data,
                    data: [...this.allReplies.data, ...response.data.data],
                };
            });
        },
    },
};
</script>
