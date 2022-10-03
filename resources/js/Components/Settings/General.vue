<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

const page = usePage();

const form = useForm({
  name: page.props.value.auth.user.name,
  email: page.props.value.auth.user.email,
});

const submit = () => {
  form.post(route("settings.general"));
};
</script>

<template>
  <div class="p-4 bg-white rounded-lg shadow">
    <form @submit.prevent="submit">
      <!-- Name -->
      <div>
        <label for="name">Name</label>
        <input id="name" type="text" v-model="form.name" required />
        <InputError class="mt-2" :message="form.errors.name" />
      </div>
      <!-- /Name -->

      <!-- Email -->
      <div class="my-4">
        <label for="email">Email</label>
        <input id="email" type="email" v-model="form.email" required />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>
      <!-- /Email -->

      <div class="text-right">
        <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
      </div>
    </form>
  </div>
</template>