<template>
    <div class="flex">
        <icons :icon="icon" class="pr-1"></icons>
        <slot></slot>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

export default {
    components: {
        Icons,
    },
    
    props: {
        icon: String,
    },
};
</script>