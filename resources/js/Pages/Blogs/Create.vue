<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import CreateEditBlog from "@/Components/Blogs/CreateEditBlog.vue";
</script>

<template>
  <Head title="Create New Blog" />
  <AuthenticatedLayout>
    <CreateEditBlog />
  </AuthenticatedLayout>
</template>