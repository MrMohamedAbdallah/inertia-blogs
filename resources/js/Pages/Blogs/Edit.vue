<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import CreateEditBlog from "@/Components/Blogs/CreateEditBlog.vue";

const props = defineProps(["blog"]);
</script>

<template>
  <Head title="Edit" />
  <AuthenticatedLayout>
    <CreateEditBlog :blog="blog" />
  </AuthenticatedLayout>
</template>