<template>
    <div
        ref="opinion-content"
        class="w-full sm:rounded-md mt-2 bg-white dark:bg-gray-900 dark:text-white shadow"
    >
        <form @submit.prevent="submit">
            <tiptap-editor
                :placeholder="placeholder"
                @opinionData="form.opinion = $event"
                @opinionDataLength="opinionDataLength = $event"
            ></tiptap-editor>

            <div class="flex justify-between items-center">
                <button
                    :disabled="disabledSubmit"
                    class="bg-blue-400 w-24 h-8 rounded-full m-2 disabled:opacity-50"
                >
                    Create
                </button>

                <span
                    :class="{ 'text-red-500': opinionDataLength > 280 }"
                    class="m-2"
                    v-text="charactersCount"
                ></span>
            </div>
        </form>
    </div>
</template>

<script>
import TiptapEditor from "@/Components/TiptapEditor";

export default {
    components: {
        TiptapEditor,
    },

    props: {
        parent: null,
        placeholder: null,
    },

    data() {
        return {
            form: {
                parent_id: this.parent,
                opinion: "",
            },
            opinionDataLength: 0,
        };
    },

    computed: {
        disabledSubmit() {
            return this.opinionDataLength == 0 || this.opinionDataLength > 280;
        },

        charactersCount() {
            return this.opinionDataLength + " / 280";
        },
    },

    methods: {
        submit() {
            if (this.disabledSubmit) {
                return;
            }

            this.$inertia.post(route("opinion.store"), this.form, {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },
    },
};
</script>
