<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
  title: "",
  body: "",
  cover: null,
});

const submit = () => {
  form.post(route("blogs.store"));
};
</script>

<template>
  <Head title="Create New Blog" />
  <AuthenticatedLayout>
    <div class="my-6">
      <form @submit.prevent="submit">
        <!-- Title -->
        <div>
          <label for="title">Title</label>
          <input id="title" type="text" v-model="form.title" />
          <InputError class="mt-2" :message="form.errors.title" />
        </div>
        <!-- /Title -->

        <!-- Body -->
        <div class="mt-4">
          <label for="body">Body</label>
          <textarea
            id="body"
            v-model="form.body"
            class="block w-full mt-1"
            rows="5"
          ></textarea>
          <InputError class="mt-2" :message="form.errors.body" />
        </div>
        <!-- /Body -->

        <div class="mt-4">
          <input
            type="file"
            name="cover"
            id="cover"
            @input="form.cover = $event.target.files[0]"
          />
          <InputError class="mt-2" :message="form.errors.cover" />
        </div>

        <div class="mt-4 text-right">
          <PrimaryButton :disabled="form.processing">Create</PrimaryButton>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>