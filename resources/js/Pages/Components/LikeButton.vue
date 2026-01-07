<script setup>

import HeartIcon from "./Icons/HeartIcon.vue";

defineProps({
    active: {type: Boolean, default: false},
    count: {type: Number, default: 0},
})
</script>

<template>
    <div class="flex items-center gap-1">
        <button aria-label="Like" :class="active ? 'hover:text-pixel text-pixel' : ''">
            <HeartIcon />
        </button>
        <span :class="active ? 'hover:text-pixel text-pixel' : ''" class="text-sm">{{ count }}</span>
    </div>

</template>
