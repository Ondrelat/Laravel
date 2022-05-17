
<template>
    <Head title="Articles" />
    <div class="flex justify-between mb-6 p-6">
        <div class="flex items-center">
      <h1 class="text-3xl">Mes classements</h1> 
    </div>
    <input v-model="search" type="text" placeholder="Recherche..." class="border px-2 rounded-lg" />
  </div>
                           
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">        
              <tr v-for="tier_list in tier_lists.data" :key="tier_list.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex flex-row space-x-10 ...">   
                    <div class="">
                      <Link :href="`/TierList/${tier_list.name}/${$page.props.auth.user.username}`">{{ tier_list.name }}</Link>                 
                    </div>
                    <div class="flex-1">
                      <p>Nombre d'article classé : <b>{{tier_list.countArticle}}</b></p>
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
  <Pagination :links="tier_lists.links" class="mt-6" />
</template>

<script setup>

import Pagination from '../Shared/Pagination';
import { ref, watch } from "vue";
import {Inertia} from "@inertiajs/inertia";
import debounce from "lodash/debounce";
import SideNav from "../Shared/SideNav"
let props = defineProps({
  tier_lists: Object,
  filters: Object,
  can: Object,
  category: Object,
  auth: Object
});
let search = ref(props.filters.search);
watch(search, debounce(function (value) {
  Inertia.get('/', { search: value }, { preserveState: true, replace: true });
}, 300));
</script>