<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import BlogsRow from "../Components/BlogsRow.vue";

defineProps({
  blogs: Object,
});
</script>

<template>
  <Head title="Welcome" />

  <BaseLayout>
    <BlogsRow class="pb-10 mt-4" :blogs="blogs" />
  </BaseLayout>
</template>
