<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

const form = useForm({
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("settings.password"), {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <div class="p-4 bg-white rounded-lg shadow">
    <form @submit.prevent="submit">
      <!-- Password -->
      <div>
        <label for="password">Password</label>
        <input id="password" type="password" v-model="form.password" required />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>
      <!-- /Password -->

      <!-- Password Confirmation -->
      <div class="my-4">
        <label for="password">Password Confirmation</label>
        <input
          id="password_confirmation"
          type="password"
          v-model="form.password_confirmation"
          required
        />
        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>
      <!-- /Password Confirmation -->

      <div class="text-right">
        <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
      </div>
    </form>
  </div>
</template>