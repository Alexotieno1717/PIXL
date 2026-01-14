<script setup>

import Logo from "./Logo.vue";
import {computed} from "vue";
import {usePage} from "@inertiajs/vue3";

let currentProfile = computed(() => {
    return usePage().props.auth.user.profile;
});
</script>

<template>
    <header class="my-4 hidden w-48 shrink-0 flex-col justify-between gap-8 pl-4 sm:flex xl:ml-32">
        <div class="">
            <!-- Logo -->
            <a href="/">
                <Logo />
            </a>

            <!-- Navigation -->
            <nav class="mt-10">
                <ul class="flex flex-col gap-3.5">
                    <li class="flex  items-center gap-2">
                        <div v-if="$page.component === 'Posts/Index'" class="bg-pixel -ml-4 size-2 shrink-0"></div>
                        <a :href="route('posts.index')" class="hover:underline" :class="{ 'text-pixel': $page.component === 'Posts/Index' }">Home</a>
                    </li>
                    <li>
                        <a :href="route('profile.show', currentProfile)" class="hover:underline" :class="{ 'text-pixel': $page.component === 'Profiles/Show' }">Profile</a>
                    </li>
                    <li><a class="hover:underline" href="#">Explore</a></li>
                    <li class="flex items-center gap-2">
                        <a class="hover:underline" href="#">Notifications</a>
                    </li>

                    <li><a class="hover:underline" href="#">Lists</a></li>
                    <li><a class="hover:underline" href="#">Bookmarks</a></li>
                    <li><a class="hover:underline" href="#">Jobs</a></li>
                    <li><a class="hover:underline" href="#">Communities</a></li>
                    <li><a class="hover:underline" href="#">Premium</a></li>
                    <li><a class="hover:underline" href="#">More</a></li>
                </ul>
            </nav>
        </div>

        <div class="flex flex-col gap-6">
            <!-- TODO: This should only display if we are NOT on the posts.index route. -->
            <Link v-show="$page.component !== 'Posts/Index'" :href="route('posts.index')"
                  class="bg-pixl hover:bg-pixl/90 active:bg-pixl/95 text-pixl-dark border border-transparent px-4 py-3 text-sm text-center">
                Post
            </Link>
            <!-- User controls -->
            <div class="flex gap-3.5">
                <a :href="route('profile.show', currentProfile)" class="shrink-0">
                    <img :src="currentProfile.avatar_url"
                         :alt="`Avatar for ${currentProfile.handle}`" class="size-11 object-cover" />
                </a>
                <div class="flex flex-col gap-1 text-sm">
                    <p>{{ currentProfile.display_name }}</p>
                    <p class="text-pixl-light/60">@{{ currentProfile.handle }}</p>
                </div>
                <button class="group flex gap-[3px] py-2" aria-label="Post options">
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                </button>
            </div>
        </div>
    </header>

</template>

