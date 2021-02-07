<template>
    <div>
        <div
            class="w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md rounded-md bg-white shadow"
        >
            <div class="pb-2 m-1 flex" v-show="opinion.parent_id">
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
            </div>
            <div>
                <div class="flex items-center">
                    <inertia-link
                        :href="route('user', opinion.user)"
                        class="h-12 w-12 m-1 mr-3 flex-shrink-0"
                    >
                        <img
                            class="w-12 h-12 rounded-full container hover:opacity-80 flex-shrink-0 object-cover"
                            :src="opinion.user.profile_photo_url"
                        />
                    </inertia-link>
                    <inertia-link :href="route('user', opinion.user)">
                        <div class="font-bold hover:underline">
                            {{ opinion.user.name }}
                        </div>
                        <div class="text-gray-500">
                            @{{ opinion.user.username }}
                        </div>
                    </inertia-link>
                </div>
                <div class="w-full">
                    <div @click="visit(opinion)">
                        <div
                            class="my-2 break-words mx-1"
                            :class="{ 'cursor-pointer': linkReplies }"
                            v-html="opinion.opinion"
                        ></div>
                    </div>
                    <span class="text-gray-500 m-1" :title="opinion.created_at">
                        {{ opinion.created_at_human }}
                    </span>
                    <div class="border-t my-2 mx-1"></div>
                    <div
                        class="text-gray-500 mx-1 flex justify-between items-center"
                    >
                        <div class="flex space-x-4">
                            <LikeButton :opinion="opinion" />
                            <span class="flex">
                                <Icons icon="chat" class="pr-1" />
                                {{ opinion.replies_count }}
                            </span>
                        </div>
                        <DestroyButton
                            v-if="canDestroy(opinion)"
                            :opinion="opinion"
                        />
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
    },
};
</script>