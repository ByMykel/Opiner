<template>
    <div>
        <div
            class="text-black w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md border border-gray-500 rounded-md"
        >
            <div class="pb-2 pl-2">
                <inertia-link
                    :href="route('opinion', opinion.parent_id)"
                    v-if="opinion.parent_id && showOpinionReplayed"
                >
                    <div class="font-semibold">
                        Replying to
                        <span class="text-blue-400">
                            @{{ opinion.parent.user.username }}
                        </span>
                    </div>
                </inertia-link>
            </div>
            <div class="flex">
                <inertia-link
                    :href="route('user', opinion.user)"
                    class="h-12 w-12 m-1 mr-3 flex-shrink-0"
                >
                    <img
                        class="w-12 h-12 rounded-full container hover:opacity-80 flex-shrink-0"
                        :src="opinion.user.profile_photo_url"
                        alt=""
                    />
                </inertia-link>
                <div class="w-full">
                    <inertia-link
                        :href="route('opinion', opinion.id)"
                        v-if="linkReplies"
                    >
                        <inertia-link
                            :href="route('user', opinion.user)"
                            class=""
                            @mouseover="hoverUser = true"
                            @mouseleave="hoverUser = false"
                        >
                            <span
                                class="font-bold"
                                :class="{ underline: hoverUser }"
                                >{{ opinion.user.name }}</span
                            >
                            <span class="text-blue-400"
                                >@{{ opinion.user.username }}</span
                            >
                        </inertia-link>
                        <span class="mx-2">·</span
                        ><span
                            class="hover:underline"
                            :title="opinion.created_at"
                            >{{ opinion.created_at_human }}</span
                        >
                        <div class="mb-1 mr-1 break-all">
                            {{ opinion.opinion }}
                        </div>
                    </inertia-link>
                    <div v-else>
                        <inertia-link
                            :href="route('user', opinion.user)"
                            class=""
                            @mouseover="hoverUser = true"
                            @mouseleave="hoverUser = false"
                        >
                            <span
                                class="font-bold"
                                :class="{ underline: hoverUser }"
                                >{{ opinion.user.name }}</span
                            >
                            <span class="text-blue-400"
                                >@{{ opinion.user.username }}</span
                            >
                        </inertia-link>
                        <span class="mx-2">·</span
                        ><span
                            class="text-blue-400 hover:underline"
                            :title="opinion.created_at"
                            >{{ opinion.created_at_human }}</span
                        >
                        <div class="mb-1 mr-1 break-all">
                            {{ opinion.opinion }}
                        </div>
                    </div>
                    <div class="flex justify-around">
                        <div class="flex">
                            <Icons icon="chat" />
                            <span class="pl-1">{{
                                opinion.replies_count
                            }}</span>
                        </div>
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

export default {
    props: {
        opinion: null,
        linkReplies: Boolean,
        showOpinionReplayed: Boolean,
    },
    data() {
        return {
            hoverUser: false,
        };
    },
    components: {
        Icons,
        LikeButton
    }
};
</script>
