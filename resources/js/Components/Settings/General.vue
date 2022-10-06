<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const page = usePage();

const profileInput = ref(null);

const form = useForm({
  name: page.props.value.auth.user.data.name,
  email: page.props.value.auth.user.data.email,
  profilePicture: null,
});

const submit = () => {
  form.post(route("settings.general"), {
    onSuccess() {
      profileInput.value.value = "";
    },
  });
};
</script>

<template>
  <div class="p-4 bg-white rounded-lg shadow">
    <div class="mb-6">
      <div class="w-20 h-20 overflow-hidden bg-gray-300 rounded-full">
        <img
          :src="$page.props.auth.user.data.profilePicture"
          :alt="$page.props.auth.user.data.name"
          class="object-cover object-center w-full h-full"
        />
      </div>
    </div>

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

      <!-- Email -->
      <div class="my-4">
        <div class="flex items-center">
          <label for="profile_picture" class="mr-2">Profile Picture: </label>
          <input
            type="file"
            name="profile_picture"
            id="profile_picture"
            ref="profileInput"
            @input="form.profilePicture = $event.target.files[0]"
          />
        </div>
        <InputError class="mt-2" :message="form.errors.profilePicture" />
      </div>
      <!-- /Email -->

      <div class="text-right">
        <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
      </div>
    </form>
  </div>
</template>