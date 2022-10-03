<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
  <AuthenticatedLayout v-if="$page.props.auth.user">
    <slot />
  </AuthenticatedLayout>
  <div v-else class="bg-gray-100">
    <nav class="bg-white border-b border-gray-100">
      <!-- Primary Navigation Menu -->
      <div class="container">
        <div class="flex items-center justify-between h-16">
          <!-- Logo -->
          <div class="flex items-center shrink-0">
            <Link href="/">
              <ApplicationLogo class="block w-auto h-9" />
            </Link>
          </div>
          <div>
            <Link
              :href="route('login')"
              class="text-sm text-gray-700 underline dark:text-gray-500"
              >Log in</Link
            >

            <Link
              :href="route('register')"
              class="ml-4 text-sm text-gray-700 underline dark:text-gray-500"
              >Register</Link
            >
          </div>
        </div>
      </div>
    </nav>

    <main class="container">
      <slot />
    </main>
  </div>
</template>