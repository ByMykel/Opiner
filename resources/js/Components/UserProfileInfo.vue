<template>
    <div class="flex">
        <Icons :icon="icon" class="pr-1" />
        <slot></slot>
    </div>
</template>

<script>
import Icons from "@/Components/Icons";

export default {
    props: {
        icon: String
    },
    components: {
        Icons
    }
}
</script>