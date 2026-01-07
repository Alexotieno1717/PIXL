<script setup>

import Logo from "./Logo.vue";
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
                    <li><a class="hover:underline" href="route('posts.index')">Home</a></li>
                    <li><a class="hover:underline" href="#">Explore</a></li>
                    <!-- Active item -->
                    <li class="flex -ml-4 items-center gap-2">
                        <div class="bg-pixel size-2 shrink-0"></div>
                        <a class="hover:underline" href="#">Notifications</a>
                    </li>

                    <li><a class="hover:underline" href="#">Lists</a></li>
                    <li><a class="hover:underline" href="#">Bookmarks</a></li>
                    <li><a class="hover:underline" href="#">Jobs</a></li>
                    <li><a class="hover:underline" href="#">Communities</a></li>
                    <li><a class="hover:underline" href="#">Premium</a></li>
                    <li><a class="hover:underline" href="#">Profile</a></li>
                    <li><a class="hover:underline" href="#">More</a></li>
                </ul>
            </nav>
        </div>

        <div class="flex flex-col gap-6">
            <!--  TODO: This should only display if we are not on the posts.index route -->
            <button
                class="bg-pixel hover:bg-pixel/90 active:bg-pixel/95 text-pixel-dark border border-transparent px-4 py-3 text-sm"
            >
                Post
            </button>
            <!--             User controls -->
            <div class="flex gap-3.5">
                <a href="/profile" class="shrink-0">
                    <img
                        src="/images/adrian.png"
                        alt="Avatar for Adrian"
                        class="size-11 object-cover"
                    />
                </a>
                <div class="flex flex-col gap-1 text-sm">
                    <p>_adrian</p>
                    <p class="text-pixel-light/60">@tudssss</p>
                </div>
                <button class="group flex gap-[3px] py-2" aria-label="Post options">
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
        </div>
    </header>

</template>

