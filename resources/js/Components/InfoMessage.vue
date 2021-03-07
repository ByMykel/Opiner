<template>
    <div class="w-full text-center text-md pt-10 dark:text-white">
        {{ text }}
    </div>
</template>

<script>
export default {
    props: {
        text: String,
    },
};
</script>