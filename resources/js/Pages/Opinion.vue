<template>
    <app-layout>
        <inertia-link
            :href="route('opinion', opinion.parent_id)"
            class="flex py-4 p-4"
            v-if="opinion.parent_id"
        >
            <Icons icon="arrow-left" class="pr-5" />

            <div class="font-semibold">
                Replying to
                <span class="text-blue-400"
                    >@{{ opinion.parent.user.username }}</span
                >
            </div>
        </inertia-link>
        <OpinionCard
            :opinion="opinion"
            :linkReplies="false"
            :showOpinionReplayed="false"
        />
        <div class="mt-10"></div>
        <OpinionCreate :parent="opinion.id" placeholder="Type your reply" />
        <OpinionCard
            :opinion="opinion"
            :linkReplies="true"
            v-for="opinion in replies"
            :key="opinion.id"
            :showOpinionReplayed="false"
        />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import OpinionCreate from "@/Components/OpinionCreate";
import Icons from "@/Components/Icons";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        user: null,
        opinion: null,
        replies: null,
    },
    components: {
        AppLayout,
        OpinionCard,
        OpinionCreate,
        Icons,
    },
};
</script>
