<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import General from "@/Components/Settings/General.vue";
import Password from "@/Components/Settings/Password.vue";
</script>

<template>
  <Head title="Settings" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Settings
      </h2>
    </template>

    <div class="grid grid-cols-1 gap-4 py-10 lg:grid-cols-2">
      <div>
        <General />
      </div>
      <div>
        <Password />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
