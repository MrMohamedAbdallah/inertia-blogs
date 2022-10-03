<script setup>
import BlogCard from "./BlogCard.vue";
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
  blogs: null,
});
</script>


<template>
  <div>
    <div class="grid grid-cols-3 gap-4">
      <BlogCard v-for="blog in blogs.data" :key="blog.id" :blog="blog" />
    </div>
    <div class="flex items-center justify-between my-10">
      <Link
        :href="blogs.links.prev"
        :disabled="!blogs.links.prev"
        as="button"
        class="px-4 py-2 text-sm text-white bg-indigo-900 rounded  disabled:opacity-70 disabled:cursor-not-allowed hover:bg-indigo-800"
      >
        Previous
      </Link>
      <Link
        :href="blogs.links.next"
        :disabled="!blogs.links.next"
        as="button"
        class="px-4 py-2 text-sm text-white bg-indigo-900 rounded  disabled:opacity-70 disabled:cursor-not-allowed hover:bg-indigo-800"
      >
        Next
      </Link>
    </div>
  </div>
</template>