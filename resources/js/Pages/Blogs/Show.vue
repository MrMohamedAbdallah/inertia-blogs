<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps(["blog"]);

const deleteForm = useForm();

const deleteSubmit = () => {
  if (!confirm("Are you sure you want to delete that blog?")) return;
  deleteForm.delete(route("blogs.destroy", props.blog.data));
};
</script>

<template>
  <Head :title="blog.data.title">
    <meta name="description" :content="blog.data.body" />
  </Head>

  <BaseLayout>
    <div class="max-w-4xl mx-auto my-8">
      <div
        class="flex items-center justify-between my-8"
        v-if="blog.data.can.edit || blog.data.can.delete"
      >
        <Link
          v-if="blog.data.can.edit"
          :href="route('blogs.edit', blog.data)"
          class="px-4 py-2 text-sm text-white rounded  bg-slate-900 hover:bg-slate-800"
        >
          Edit
        </Link>
        <button
          v-if="blog.data.can.delete"
          @click="deleteSubmit"
          class="px-4 py-2 text-sm text-white bg-red-600 rounded  hover:bg-red-500"
        >
          Delete
        </button>
      </div>
      <h1 class="mb-4 text-2xl font-bold lg:text-7xl">
        {{ blog.data.title }}
      </h1>
      <div class="max-w-xl mx-auto mb-8">
        <img
          v-if="blog.data.cover"
          :src="blog.data.cover"
          :alt="blog.data.title"
          class="w-full rounded-lg"
        />
      </div>
      <div v-html="blog.data.bodyHTML" class="prose lg:prose-xl"></div>
    </div>
  </BaseLayout>
</template>
