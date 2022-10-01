<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";

defineProps(["blog"]);
</script>

<template>
  <Head :title="blog.data.head" />

  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto my-8">
      <div class="max-w-xl mx-auto mb-8">
        <img
          v-if="blog.data.cover"
          :src="blog.data.cover"
          :alt="blog.data.title"
          class="w-full rounded-lg"
        />
      </div>
      <h1 class="mb-4 text-2xl font-bold lg:text-4xl">{{ blog.data.title }}</h1>
      <pre class="font-sans text-base whitespace-normal lg:text-lg">{{
        blog.data.body
      }}</pre>
    </div>
  </AuthenticatedLayout>
</template>
