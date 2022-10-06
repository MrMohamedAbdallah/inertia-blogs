<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { QuillEditor } from "@vueup/vue-quill";
import ImageUploader from "quill-image-uploader";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import axios from "axios";
import { QuillDeltaToHtmlConverter } from "quill-delta-to-html";
import { ref } from "vue";

const props = defineProps(["blog"]);

const modules = {
  name: "imageUploader",
  module: ImageUploader,
  options: {
    upload: (file) => {
      return new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append("image", file);

        axios
          .post("/upload-image", formData)
          .then((res) => {
            resolve(res.data.url);
          })
          .catch((err) => {
            reject("Upload failed");
          });
      });
    },
  },
};

const toolbar = [
  [{ header: [1, 2, 3, 4, 5, 6, false] }],
  ["bold", "italic", "underline", "strike"], // toggled buttons
  ["blockquote", "code-block"],
  [{ color: [] }, { background: [] }],
  [{ header: 1 }, { header: 2 }], // custom button values
  [{ list: "ordered" }, { list: "bullet" }],
  [{ direction: "rtl" }], // text direction
  ["image"],
  ["clean"], // remove formatting button
];

const form = useForm({
  title: props.blog ? props.blog.data.title : "",
  body: "",
  cover: null,
});

const body = ref({});

const handleReady = (quill) => {
  const html = props.blog ? props.blog.data.bodyHTML : "";
  const delta = quill.clipboard.convert(html);
  quill.setContents(delta);
};

const create = (html) => {
  form
    .transform((data) => ({
      ...data,
      body: html,
    }))
    .post(route("blogs.store"));
};

const update = (html) => {
  form
    .transform((data) => ({
      ...data,
      body: html,
      _method: "put",
    }))
    .post(route("blogs.edit", props.blog.data.id));
};

const submit = () => {
  let converter = new QuillDeltaToHtmlConverter(body.value.ops);
  let html = converter.convert();

  if (props.blog) update(html);
  else create(html);
};
</script>

<template>
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
        <div class="bg-white">
          <QuillEditor
            theme="snow"
            :toolbar="toolbar"
            :modules="modules"
            @ready="handleReady"
            v-model:content="body"
          />
        </div>
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
        <PrimaryButton :disabled="form.processing">
          {{ blog ? "Update" : "Create" }}
        </PrimaryButton>
      </div>
    </form>
  </div>
</template>