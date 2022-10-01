<script setup>
import BlogCard from "./BlogCard.vue";

const props = defineProps({
  blogs: null,
});
</script>


<template>
  <div class="grid grid-cols-3 gap-4">
    <BlogCard v-for="blog in blogs.data" :key="blog.id" :blog="blog" />
  </div>
</template>