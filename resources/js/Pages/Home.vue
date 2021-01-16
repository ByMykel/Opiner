<template>
    <app-layout>
        <OpinionCreate :parent="null" placeholder="What's happening?" />
        <OpinionCard
            :opinion="opinion"
            :linkReplies="true"
            v-for="opinion in timeline"
            :key="opinion.id"
            :showOpinionReplayed="true"
        />
        <div class="text-center pt-10" v-if="timeline.length == 0">
            No Opinions yet
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import OpinionCard from "@/Components/OpinionCard";
import OpinionCreate from "@/Components/OpinionCreate";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        timeline: null,
    },
    components: {
        AppLayout,
        OpinionCard,
        OpinionCreate,
    },
    methods: {
        like(opinion) {
            Inertia.post(route("opinion.like", opinion.id), [], {
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },
    },
};
</script>
