<script setup>
import Navigation from "../Pages/Components/Navigation.vue";
import Aside from "../Pages/Components/Aside.vue";
import FlashMessages from "../Pages/Components/FlashMessages.vue";

</script>

<template>
    <div class="bg-pixel-dark text-pixel-light flex gap-16 px-4 h-dvh overflow-clip">
        <Navigation />

        <slot />

        <Aside />

        <FlashMessages />
    </div>
</template>

<style scoped>

</style>
