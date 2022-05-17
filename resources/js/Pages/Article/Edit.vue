<template>
  <Head title="Create User" />

  <h1 class="text-3xl p-6 text-center">Modifier l'article</h1>

  <form @submit.prevent="submit" class="max-w-md mx-auto mt-8">
    <div class="mb-6">
      <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="title"> Titre </label>

      <input v-model="form.title" class="border border-gray-400 p-2 w-full" type="text" title="title" id="title" required />
          <div v-if="form.errors.title" v-text="form.errors.title" class="text-red-500 text-xs mt-1"></div>
    </div>

    <div class="mb-6">
      <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="content"> Contenu </label>

       <input v-model="form.content" class="border border-gray-400 p-2 w-full" type="content" name="content" id="content" required />

       <div v-if="form.errors.content" v-text="form.errors.content" class="text-red-500 text-xs mt-1"></div>
    </div>

    <div class="mb-6">
      <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="image"> Image </label>
       <input type="file" @input="form.image = $event.target.files[0]" />
    </div>

    <div class="mb-6">
      <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500" :disabled="article.processing">Modifier</button>
    </div>
  </form>
</template>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
  article: Object
});

let form = useForm({
  title: props.article.title,
  content: props.article.content,
  image: props.article.image,
});

let submit = () => {
  form.post("edit");
};
</script>