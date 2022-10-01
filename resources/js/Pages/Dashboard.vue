<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import BlogsRow from "../Components/BlogsRow.vue";

defineProps({
  blogs: null,
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="my-8 text-right">
      <Link
        :href="route('blogs.create')"
        class="px-4 py-2 text-sm text-white rounded  bg-slate-900 hover:bg-slate-800"
      >
        Create New Blog
      </Link>
    </div>

    <BlogsRow class="pb-10 mt-4" :blogs="blogs" />
  </AuthenticatedLayout>
</template>
