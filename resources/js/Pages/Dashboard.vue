<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import BlogsRow from "../Components/BlogsRow.vue";

defineProps({
  blogs: Array,
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

    <div class="py-12">
      <div class="mx-auto">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            You're logged in!
          </div>
        </div>
      </div>
    </div>

    <BlogsRow class="pb-10 mt-4" :blogs="blogs" />
  </AuthenticatedLayout>
</template>
