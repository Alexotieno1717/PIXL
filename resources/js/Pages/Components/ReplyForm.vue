<script setup>

import {Form} from "@inertiajs/vue3";
import ImageIcon from "./Icons/ImageIcon.vue";
import VideoIcon from "./Icons/VideoIcon.vue";

defineProps({
    profile: Object,
    post: Object,
})
let emit = defineEmits(['success']);

</script>

<template>
    <div
        class="border-pixel-light/10 bg-pixel-light/[3%] mt-8 flex items-start gap-4 border-t p-4"
    >
        <a :href="route('profile.show', profile)" class="shrink-0">
            <img
                :src="profile.avatar_url"
                :alt="`Avatar for ${profile.display_name }`"
                class="size-10 object-cover"
            />
        </a>

        <Form class="grow" method="POST" :action="route('posts.reply', [post.profile, post])" resetOnSuccess #default="{ errors }"  @success="emit('success')">
            <label class="sr-only" for="content">Reply body</label>
            <textarea
                class="w-full resize-none text-lg"
                name="content"
                id="content"
                :placeholder="`Reply to ${post.profile.display_name} post`"
                rows="5"
            ></textarea>
            <div v-if="errors.content" v-text="errors.content" class="text-xs text-red-500" />
            <div class="flex items-center justify-between gap-4">
                <div class="flex gap-4">
                    <button type="button">
                        <ImageIcon />
                    </button>
                    <button type="button">
                        <VideoIcon />
                    </button>
                </div>
                <button
                    type="submit"
                    class="bg-pixel hover:bg-pixel/90 active:bg-pixel/95 text-pixel-dark border border-transparent px-4 py-1 text-sm"
                >
                    Post
                </button>
            </div>
        </Form>

    </div>

</template>
