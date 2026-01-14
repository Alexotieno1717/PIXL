<script setup>


import RepostIcon from "./Icons/RepostIcon.vue";
import {Form} from "@inertiajs/vue3";

defineProps({
    post: Object,
})
</script>

<template>
    <Form method="POST"  v-if="post && post.profile" :action="route('posts.repost', [post.profile, post])">
        <div class="flex items-center gap-1">
            <button aria-label="Re-post" :class="post.has_reposted ? 'hover:text-pixel text-pixel' : ''">
                <RepostIcon />
            </button>
            <span :class="post.has_reposted ? 'hover:text-pixel text-pixel' : ''" class="text-sm">{{ post.reposts_count }}</span>
        </div>
    </Form>

</template>

