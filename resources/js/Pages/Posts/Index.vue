<script setup>
  import { Head } from '@inertiajs/vue3'
  import Layout from "@/Layouts/layout.vue";
  import PostForm from "../Components/PostForm.vue";
  import Post from "../Components/Post.vue";
  import AppFooter from "../Components/AppFooter.vue";

  defineProps({
      profile: Object,
      posts: Array
  })
</script>

<template>
  <Layout>
      <main class="-mx-4 flex grow flex-col gap-4 overflow-y-auto px-4 py-4">
          <div class="h-full">
              <nav class="overflow-x-auto [scrollbar-width:none]">
                  <ul class="flex min-w-max justify-end gap-8 text-sm">
                      <li><a href="#">For you</a></li>
                      <li>
                          <a class="text-pixel-light/60 hover:text-pixel-light/80" href="#"
                          >Idea streams</a
                          >
                      </li>
                      <li>
                          <a class="text-pixel-light/60 hover:text-pixel-light/80" href="#"
                          >Following</a
                          >
                      </li>
                  </ul>
              </nav>
          </div>

          <!-- Post prompt -->
          <PostForm :profile="profile" />

          <!-- Feed -->
          <ol class="mt-4">
              <Post v-for="item in posts" :key="item.id" :post="item" />
          </ol>

          <AppFooter />
      </main>

  </Layout>
</template>
