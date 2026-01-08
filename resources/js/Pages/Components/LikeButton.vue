<script setup>

import HeartIcon from "./Icons/HeartIcon.vue";
import {Form} from "@inertiajs/vue3";

defineProps({
    post: Object
})
</script>

<template>
    <Form method="POST" :action="route(post.has_liked ?'posts.unlike' : 'posts.like', [post.profile, post])">
        <div class="flex items-center gap-1">
            <button aria-label="Like" :class="post.has_liked ? 'hover:text-pixel text-pixel' : ''">
                <HeartIcon />
            </button>
            <span :class="post.has_liked ? 'hover:text-pixel text-pixel' : ''" class="text-sm">{{ post.likes_count }}</span>
        </div>
    </Form>
</template>
