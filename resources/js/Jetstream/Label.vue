<template>
    <label class="block font-medium text-sm text-gray-700">
        <div>
            <span v-if="value">{{ value }}</span>
            <span v-else><slot></slot></span>
        </div>
    </label>
</template>

<script>
    export default {
        props: ['value']
    }
</script>
