<template>
    <div>
        <div
            class="w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md rounded-md bg-white shadow"
        >
            <div
                class="pb-2 pl-2 flex"
                :class="[jusitfy(opinion) ? 'justify-between' : 'justify-end']"
            >
                <inertia-link
                    :href="route('opinion', opinion.parent_id)"
                    v-if="showRepliedUser(opinion)"
                >
                    <div class="font-semibold">
                        Replying to
                        <span class="text-blue-400">
                            @{{ opinion.parent.user.username }}
                        </span>
                    </div>
                </inertia-link>
                <DestroyButton
                    v-if="canDestroy(opinion)"
                    class="flex items-end"
                    :opinion="opinion"
                />
            </div>
            <div class="flex">
                <inertia-link
                    :href="route('user', opinion.user)"
                    class="h-12 w-12 m-1 mr-3 flex-shrink-0"
                >
                    <img
                        class="w-12 h-12 rounded-full container hover:opacity-80 flex-shrink-0 object-cover"
                        :src="opinion.user.profile_photo_url"
                    />
                </inertia-link>
                <div class="w-full">
                    <div @click="visit(opinion)">
                        <inertia-link :href="route('user', opinion.user)">
                            <span class="font-bold hover:underline">{{
                                opinion.user.name
                            }}</span>
                        </inertia-link>
                        <span class="mx-2">·</span>
                        <span
                            class="hover:underline"
                            :title="opinion.created_at"
                            >{{ opinion.created_at_human }}</span
                        >

                        <div
                            class="mb-1 mr-1 break-all"
                            :class="{ 'cursor-pointer': linkReplies }"
                        >
                            {{ opinion.opinion }}
                        </div>
                    </div>
                    <div class="flex justify-around">
                        <span class="flex">
                            <Icons icon="chat" class="pr-1" />
                            {{ opinion.replies_count }}
                        </span>
                        <LikeButton :opinion="opinion" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";
import LikeButton from "@/Components/LikeButton";
import DestroyButton from "@/Components/DestroyButton";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        opinion: Object,
        linkReplies: Boolean,
    },
    components: {
        Icons,
        LikeButton,
        DestroyButton,
    },
    methods: {
        visit(opinion) {
            if (!this.linkReplies) return;

            Inertia.visit(route("opinion", opinion.id));
        },
        canDestroy(opinion) {
            return this.$page.props.auth.id === opinion.user_id;
        },
        showRepliedUser(opinion) {
            return (
                opinion.parent_id &&
                !route().current("opinion", opinion.parent_id)
            );
        },
        jusitfy(opinion) {
            return (
                opinion.parent_id &&
                !route().current("opinion", opinion.parent_id)
            );
        },
    },
};
</script>
