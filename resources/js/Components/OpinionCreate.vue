<template>
    <div class="w-full rounded-md mt-2 bg-white shadow" ref="opinion-content">
        <form @submit.prevent="submit">
            <Mention
                @opinionData="form.opinion = $event"
                @opinionDataLength="opinionDataLength = $event"
                :placeholder="placeholder"
            />
            <div class="flex justify-between items-center">
                <button
                    class="bg-blue-400 w-24 h-8 rounded-full m-2 disabled:opacity-50"
                    :disabled="disabledSubmit"
                >
                    Create
                </button>
                <span
                    class="m-2"
                    :class="{ 'text-red-500': opinionDataLength > 280 }"
                    >{{ opinionDataLength }} / 280</span
                >
            </div>
        </form>
    </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import Mention from "@/Components/Mention";

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
            opinionDataLength: 0,
        };
    },
    components: {
        Mention,
    },
    computed: {
        disabledSubmit() {
            return this.opinionDataLength == 0 || this.opinionDataLength > 280;
        },
    },
    methods: {
        submit() {
            if (this.disabledSubmit) {
                return;
            }

            Inertia.post(route("opinion.store"), this.form, {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },
    },
};
</script>
