<template>
 <p class="text-3xl">Cree une nouvelle catégorie</p>
  <form @submit.prevent="submit" class="max-w-md mx-auto mt-8">
    <div class="mb-6">
      <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="name"> name </label>

      <input v-model="form.name" class="border border-gray-400 p-2 w-full" type="text" name="name" id="name" required />
          <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-1"></div>
    </div>

    <div class="mb-6">
           <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500" :disabled="form.processing">Submit</button>
    </div>
  </form>
</template>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3";



let props = defineProps({
  category: Object
});

let form = useForm({
  name: '',
});

let submit = () => {
  form.post(`/category/${props.category}`);
};


</script>