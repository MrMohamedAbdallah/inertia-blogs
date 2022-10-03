<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
  blog: null,
  lettersCount: {
    default: 200,
  },
});
</script>

<template>
  <Link
    :href="route('blogs.show', blog)"
    :class="[
      'rounded-lg overflow-hidden transition-all hover:-translate-y-1 hover:scale-105 shadow bg-white',
      {
        'p-4': !blog.cover,
      },
    ]"
  >
    <div v-if="blog.cover" class="w-full h-40 bg-gray-300">
      <img
        v-if="blog.cover"
        :src="blog.cover"
        :alt="blog.title"
        class="object-cover w-full h-full object-fit"
      />
    </div>
    <div
      :class="{
        'p-4': blog.cover,
      }"
    >
      <h3
        class="mb-3 overflow-hidden text-lg font-bold  text-ellipsis whitespace-nowrap"
      >
        {{ blog.title }}
      </h3>
      <p>
        {{
          blog.body.length > lettersCount
            ? blog.body.slice(0, lettersCount) + "..."
            : blog.body
        }}
      </p>
      <div class="mt-4 text-xs" v-if="blog.user">
        By: <strong>{{ blog.user.name }}</strong>
      </div>
    </div>
  </Link>
</template>
