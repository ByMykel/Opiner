<template>
    <div>
        <div
            class="w-full mx-auto m-2 p-2 text-xs sm:text-sm md:text-md sm:rounded-md bg-white dark:bg-gray-900 dark:text-white shadow relative"
        >
            <div
                v-show="deleteConfirmation"
                class="bg-red-500 w-full h-full absolute top-0 left-0 sm:rounded-md bg-opacity-40 flex flex-col justify-center items-center"
            >
                <div>
                    <button
                        class="bg-white px-6 py-2 rounded-md mr-2 shadow hover:bg-gray-200 font-bold dark:text-black"
                        @click="deleteConfirmation = false"
                    >
                        Cancel
                    </button>

                    <opinion-card-destroy v-if="canDestroy" :opinion="opinion">
                        Delete
                    </opinion-card-destroy>
                </div>
            </div>

            <div
                v-if="opinion.reopinion_user_id !== undefined"
                class="pb-2 m-1 flex"
            >
                <a :href="route('user', opinion.reuser)">
                    <div class="font-semibold">
                        <span
                            class="text-blue-400"
                            v-text="opinion.reuser.name"
                        >
                        </span>

                        <span>reopined</span>
                    </div>
                </a>
            </div>

            <div v-else-if="showRepliedUser" class="pb-2 m-1 flex">
                <a :href="route('opinion', opinion.parent_id)">
                    <div class="font-semibold">
                        <span>Replying to</span>

                        <span
                            class="text-blue-400"
                            v-text="opinion.parent.user.username"
                        >
                        </span>
                    </div>
                </a>
            </div>

            <div>
                <div class="flex items-center">
                    <a
                        :href="route('user', opinion.user)"
                        class="h-10 w-10 m-1 mr-3 flex-shrink-0"
                    >
                        <img
                            :src="opinion.user.profile_photo_url"
                            class="w-10 h-10 rounded-full container hover:opacity-80 flex-shrink-0 object-cover"
                        />
                    </a>

                    <a :href="route('user', opinion.user)">
                        <div
                            class="font-bold hover:underline"
                            v-text="opinion.user.name"
                        ></div>

                        <div
                            class="text-gray-500 dark:text-gray-400"
                            v-text="opinion.user.username"
                        ></div>
                    </a>
                </div>

                <div class="w-full">
                    <a
                        v-if="linkReplies"
                        :href="route('opinion', opinion.id)"
                        class="select-text"
                    >
                        <div
                            :class="{ 'cursor-pointer': linkReplies }"
                            class="my-2 break-words mx-1 opinion-link"
                            v-html="opinion.opinion"
                        ></div>
                    </a>

                    <div
                        v-else
                        :class="{ 'cursor-pointer': linkReplies }"
                        class="my-2 break-words mx-1 opinion-link"
                        v-html="opinion.opinion"
                    ></div>

                    <span
                        :title="opinion.created_at"
                        class="text-gray-500 dark:text-gray-400 mx-1"
                        v-text="opinion.created_at_human"
                    >
                    </span>

                    <div
                        class="text-gray-500 mx-1 flex justify-between items-center dark:text-gray-400 mt-4"
                    >
                        <div class="flex space-x-4">
                            <opinion-card-reopinion
                                :opinion="opinion"
                            ></opinion-card-reopinion>

                            <opinion-card-like
                                :opinion="opinion"
                            ></opinion-card-like>

                            <span class="flex items-center">
                                <icons icon="chat" class="pr-1"></icons>

                                <span
                                    class="flex items-center"
                                    v-text="opinion.replies_count"
                                ></span>
                            </span>
                        </div>

                        <div
                            v-if="canDestroy"
                            @click="deleteConfirmation = true"
                        >
                            <icons
                                icon="trash"
                                class="text-gray-400 hover:text-red-400 cursor-pointer"
                            ></icons>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";
import OpinionCardLike from "@/Components/OpinionCardLike";
import OpinionCardDestroy from "@/Components/OpinionCardDestroy";
import OpinionCardReopinion from "@/Components/OpinionCardReopinion";

export default {
    components: {
        Icons,
        OpinionCardLike,
        OpinionCardDestroy,
        OpinionCardReopinion,
    },

    props: {
        opinion: Object,
        linkReplies: Boolean,
    },

    data() {
        return {
            deleteConfirmation: false,
        };
    },

    computed: {
        canDestroy() {
            return this.$page.props.auth.id === this.opinion.user_id;
        },

        showRepliedUser() {
            return (
                this.opinion.parent_id &&
                !route().current("opinion", this.opinion.parent_id) &&
                !route().current("opinion", this.opinion.id)
            );
        },
    },
};
</script>