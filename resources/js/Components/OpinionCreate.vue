<template>
    <div class="w-full border border-gray-500 rounded-md mt-2">
        <form @submit.prevent="submit">
            <textarea
                ref="opinion-content"
                @input="resizeTextarea()"
                class="w-full resize-none border-none rounded-md"
                :placeholder="placeholder"
                v-model="form.opinion"
            ></textarea>
            <div class="flex justify-between items-center">
                <button
                    class="bg-blue-400 w-24 h-8 rounded-full m-2 disabled:opacity-50"
                    :disabled="disabledSubmit"
                >
                    Create
                </button>
                <span
                    class="m-2"
                    :class="{ 'text-red-500': form.opinion.length > 280 }"
                    >{{ form.opinion.length }}/280</span
                >
            </div>
        </form>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import { Inertia } from "@inertiajs/inertia";

export default {
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
        };
    },
    components: {
        AppLayout,
    },
    computed: {
        disabledSubmit() {
            return (
                this.form.opinion.length == 0 || this.form.opinion.length > 280
            );
        },
    },
    methods: {
        submit() {
            if (this.disabledSubmit || this.form.opinion.trim().length == 0) {
                return;
            }

            Inertia.post(route("opinion.store"), this.form, {
                preserveScroll: true,
                resetOnSuccess: false,
            });

            this.form.opinion = "";
            this.$refs["opinion-content"].style.height = "initial";
        },
        resizeTextarea() {
            const textarea = this.$refs["opinion-content"];
            textarea.style.height = "initial";
            textarea.style.height = `${textarea.scrollHeight}px`;
        },
    },
};
</script>
