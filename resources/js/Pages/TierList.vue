<template>
    <Head title="Articles" />

    <div class="flex justify-between mb-6 p-6">
        <div class="flex items-center">
      <h1 class="text-2xl underline">Mon classement pour {{category.name}}</h1>
    </div>


  </div>  
      <div class="">
      <input v-model="search" v-on:blur="blur()" type="text" placeholder="Recherche..." class="border px-2 rounded-lg" />
      <div v-show="search"
      >
        <ul class="w-48 bg-gray-50">
          <li
            class="py-2 border-b cursor-pointer text-center"
            v-for="searchArticle in searchArticles.data"
            :key="searchArticle.title"
            @click="setState(searchArticle.title)"
          >
            {{ searchArticle.title }}
          </li>
        </ul>
      </div>
      <Link :href="`/TierList/${category.name}/${$page.props.auth.user.username}/${filters.search}`"  class="text-blue-500 text-sm ml-3 rounded border-2 border-r-indigo-600 p-2">Ajouter l'article</Link>                          
    </div>

<br>
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
              <draggable 
                v-model="tempData" 
                group="people" 
                @start="drag=true" 
                @end="drag=false" 
                item-key="rank"
                @change="getComponentData()">
                <template #item="{element, index}">
                    <div class="rounded border-2 border-gray p-3">
                      <div class="flex flex-row space-x-10 ...">
                        <div class="rounded border-2 border-black p-2">{{index+1}}</div>
                        <div class="flex-1">{{element.title}}</div>
                        <div class="ml-auto"><Link :href="`/TierList/delete/${category.name}/${$page.props.auth.user.username}/${element.title}`"><i class="fas fa-times"></i></Link></div> 
                     </div>
                    </div>
                </template>
              </draggable>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<br>
<br>
</template>

<script setup>

import Pagination from '../Shared/Pagination';
import { ref, watch } from "vue";
import {Inertia} from "@inertiajs/inertia";
import debounce from "lodash/debounce";
 import draggable from 'vuedraggable'

let props = defineProps({
  articles: Object,
  filters: Object,
  can: Object,
  category: Object,
  auth: Object,
  searchArticles: Object,
});

let search = ref(props.filters.search);

let tempData = ref(props.articles.data);

function getComponentData() {
  Inertia.post('/TierList/update/', tempData._value)
}

function data() {
  return {
    drag: false,
  }
}

function setState(state){
 setTimeout(() => {  this.search = state; }, 300);
}

function blur(){
  setTimeout(() => { this.search = null; }, 300);
}

watch(search, debounce(function (value) {
  Inertia.get(('/TierList/', props.category.name), { search: value }, { preserveState: true, replace: true});
}, 300));

</script>


