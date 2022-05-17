
<template>
    <SideNav />
    <Head title="Articles" />
    <div class="flex justify-between mb-4 p-4">
        <div class="flex items-center">
      <h1 class="text-3xl">{{category.name}}</h1>
      <!-- Quand l'utilisateur est  connecté -->
      <div v-if="($page.props.auth.user.username != 'Vide') && ($page.props.isTierListExist == false)">
        <Link :href="`/${category.name}/article/create`" class="text-blue-500 text-sm ml-3">Créer un article</Link>
        <Link :href="`/TierList/${category.name}/${$page.props.auth.user.username}`" class="text-blue-500 text-sm ml-3">Créer mon classement</Link>
      </div>
      <div v-if="($page.props.auth.user.username != 'Vide') && ($page.props.isTierListExist == true)">
        <Link :href="`/${category.name}/article/create`" class="text-blue-500 text-sm ml-3">Créer un article</Link>
        <Link :href="`/TierList/${category.name}/${$page.props.auth.user.username}`" class="text-blue-500 text-sm ml-3">Voir mon classement</Link>
      </div>
      <!-- Quand l'utilisateur n'est pas connecté -->
      <div v-if="$page.props.auth.user.username == 'Vide'">
        <Link :href="`/login`" class="text-blue-500 text-sm ml-3">Créer un article</Link>  
        <Link :href="`/login`" class="text-blue-500 text-sm ml-3">Créer mon classement</Link>
      </div>
    </div>

    <input v-model="search" type="text" placeholder="Recherche..." class="border px-2 rounded-lg" />
  </div>
                           
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
              <tr class="block px-2 py-1 whitespace-nowrap">
                <div class="text-sm font-medium grid grid-cols-12 gap-6 items-center">
                  <div class="col-span-2"><th scope="col">Rang</th></div>
                  <div class="col-span-6"><th scope="col">&nbsp;&nbsp;Titre</th></div>
                  <div><th scope="col">Score</th></div>
                  <div><th scope="col" class="border-left border-solid" >Nombre de vote</th></div>                                        
                </div>
              </tr>
              <tr v-for="(article, index) in articles.data" :key="article.id">
                <td class="px-6 py-1 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900 grid grid-cols-12 gap-6 items-center">
                    <div class="col-span-2 grid grid-cols-3 gap-1 items-center">
                      <div>
                        {{ index+1 }}
                      </div>
                      <div class="h-11 col-span-2">

                        <img v-if="article.image != null" class="h-11 object-fill w-10" :src="`storage/${article.image}`">
                      </div>
                    </div>
                    <div class="col-span-6 ...">
                      {{ article.title }}
                    </div>
                    <div class="col-span-2 ...">
                      <p>&nbsp;&nbsp;&nbsp;&nbsp;{{ article.score }}</p>
                    </div>
                    <div>
                      <p>{{ article.countVote }}</p>
                    </div>
                    <div>
                      <Link :href="`/${article.title}/article/edit`" v-if="($page.props.auth.user.username == 'Ondrelat')" class="text-indigo-600 hover:text-indigo-900"> Edit </Link>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
   <Pagination :links="articles.links" class="mt-3" />
</template>

<script setup>

import Pagination from '../Shared/Pagination';
import { ref, watch } from "vue";
import {Inertia} from "@inertiajs/inertia";
import debounce from "lodash/debounce";
import SideNav from "../Shared/SideNav"
let props = defineProps({
  articles: Object,
  filters: Object,
  can: Object,
  category: Object,
  auth: Object,
  isTierListExist: Object
});
let search = ref(props.filters.search);
watch(search, debounce(function (value) {
  Inertia.get('/', { search: value }, { preserveState: true, replace: true });
}, 300));
</script>


