<template>
    <ul class="list-none grid grid-cols-1 divide-y divide-gray-100 m-1">
        <tr v-for="categorie in categories" :key="categorie.id">
            <li class="hover:bg-gray-200">
                    <div class="flex">
                        <div class="flex-none">
                            <button v-if="categorie.index == 0 || !categorie.index" v-on:click="categorie.index = 1">{{ categorie.name }}</button>
                            <button v-if="categorie.index == 1" v-on:click="categorie.index = 0">{{ categorie.name }}</button> 
                        </div>
                        &nbsp;
                        &nbsp;        
                        <div class="flex-initial w-3">
                            <Link :href="`${categorie.name}`"><a class="btn" role="button"><span class=""><i class="fas fa-long-arrow-alt-right"></i></span></a></Link> 
                        </div>
                    </div>
                    <NavCategoryElement v-if="categorie.index == 1" v-bind:categories="categorie.all_children_categories">
                    </NavCategoryElement>
                    
                    <!--<Link :href="`/${categorie.name}/${categories}`">                      
                        <p>{{ categorie.name }}</p>
                    </Link>-->
            </li>
        </tr>
    </ul>
</template>

<script setup>

let props = defineProps({
  categories: Object
});

</script>