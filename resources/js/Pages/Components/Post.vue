<script setup>

import LikeButton from "./LikeButton.vue";
import ReplyButton from "./ReplyButton.vue";
import RepostButton from "./RepostButton.vue";
import SaveButton from "./SaveButton.vue";
import ShareButton from "./ShareButton.vue";
import Reply from "./Reply.vue";

defineProps({
    post: Object,
    showEngagement: {type: Boolean, default: true},
    showReplies: {type: Boolean, default: false},
})
</script>

<template>
    <li class="flex items-start gap-4 not-first:pt-2.5">
        <a :href="route('profile.show', post.profile)" class="shrink-0">
            <img
                :src="post.profile.avatar_url"
                :alt="`Avatar for ${post.profile.displayName }}`"
                class="size-10 object-cover"
            />
        </a>
        <div class="grow pt-1.5">
            <div class="border-pixel-light/10 border-b pb-5">
                <!-- User meta -->
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5">
                        <p><a class="hover:underline" :href="route('profile.show', post.profile)">{{ post.profile.display_name }}</a></p>
                        <p class="text-pixel-light/40 text-xs"><a :href="route('post.show', [$post.profile, $post])" >{{ post.created_at }}</a></p>
                        <p>
                            <a
                                class="text-pixel-light/40 hover:text-pixel-light/60 text-xs"
                                :href="route('profile.show', post.profile)"
                            >{{ post.profile.handle }}</a
                            >
                        </p>
                    </div>
                    <button
                        class="group flex gap-[3px] py-2"
                        aria-label="Post options"
                    >
                              <span
                                  class="bg-pixel-light/40 group-hover:bg-pixel-light/60 size-1"
                              ></span>
                        <span
                            class="bg-pixel-light/40 group-hover:bg-pixel-light/60 size-1"
                        ></span>
                        <span
                            class="bg-pixel-light/40 group-hover:bg-pixel-light/60 size-1"
                        ></span>
                    </button>
                </div>
                <!-- Post content -->
                <div class="[&_a]:text-pixel mt-4 flex flex-col gap-3 text-sm [&_a]:hover:underline">
                    <div v-html="post.content"></div>
                    <ul v-if="!!post.repost_of && !!post.content">
                        <Post :post="post.repost_of" :show-engagement="false" />
                    </ul>
                </div>
                <!-- Action buttons -->
                <div v-if="showEngagement" class="mt-6 flex items-center justify-between gap-4">

                    <div class="flex items-center gap-8">
                        <LikeButton :active="post.has_liked" :count="post.likes_count" :id="post.id" />
                        <ReplyButton :count="post.replies_count" :id="post.id" />
                        <RepostButton :active="post.has_reposted" :count="post.reposts_count" :id="post.id" />
                    </div>
                    <div class="flex items-center gap-3">
                        <SaveButton :id="post.id" />
                        <ShareButton :id="post.id" />
                    </div>
                </div>

<!--                <x-reply-form :post="$post" />-->

            </div>
            <!-- Threaded replies -->
            <ol v-if="showReplies">
                <Reply v-for="reply in post.replies" :post="$reply" :show-engagement="$showEngagement" :show-replies="$showReplies" />
            </ol>
        </div>
    </li>

</template>
