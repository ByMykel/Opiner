<template>
    <div v-observe-visibility="handleScrolledToBottom"></div>
</template>

<script>
export default {
    methods: {
        handleScrolledToBottom(isVisible, entry) {
            if (!isVisible) {
                return;
            }

            this.$emit("scroll");
        },
    },
};
</script>