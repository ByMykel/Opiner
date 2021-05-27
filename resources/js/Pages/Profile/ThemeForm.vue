<template>
    <div class="shadow overflow-hidden sm:rounded-md bg-white mb-10 dark:text-white dark:bg-gray-900">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between col-span-6">
                <div class="flex items-center">
                    <Icons class="mr-2" icon="moon" />
                    Dark Mode
                </div>
                <div>
                    <label
                        for="dark-mode"
                        class="flex items-center cursor-pointer"
                    >
                        <div class="relative">
                            <input
                                id="dark-mode"
                                type="checkbox"
                                class="hidden"
                                @click="changeTheme()"
                            />
                            <div
                                class="toggle__line w-8 h-4 rounded-full shadow-inner"
                                :class="show ? 'bg-green-400' : 'bg-gray-200'"
                            ></div>
                            <div
                                class="toggle__dot absolute w-4 h-4 bg-white rounded-full shadow inset-y-0 left-0 duration-150 transform"
                                :class="{ 'translate-x-full': show }"
                            ></div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

export default {
    components: {
        Icons,
    },

    data() {
        return {
            show: true,
        };
    },

    mounted() {
        if (
            localStorage.theme === "dark" ||
            (!("theme" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            this.show = true;
        } else {
            this.show = false;
        }
    },

    methods: {
        changeTheme() {
            if (this.show) {
                this.show = false;
                localStorage.theme = "light";
                document.documentElement.classList.remove("dark");
            } else {
                this.show = true;
                localStorage.theme = "dark";
                document.documentElement.classList.add("dark");
            }
        },
    },
};
</script>
