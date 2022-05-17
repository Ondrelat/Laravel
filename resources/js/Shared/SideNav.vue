<template>

<div class="row bg-white fixed object-contain left-0 h-full p-1 w-1/6 ...">
    <div class="m-4">
        <p class="text-xl font-bold text-gray-600">Catégories</p>
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
            <FormCategory v-if="$page.props.auth.user.username == 'Ondrelat'" v-bind:category="`${category.name}`" />
        </ul>
    </div>
</div>



</template>

<script>



import NavLink from "./NavLink";
import NavCategoryElement from "./NavCategoryElement";
import FormCategory from "../Pages/FormCategory";

export default {
    
  components: { NavLink, FormCategory, NavCategoryElement },

    computed: {
        username() {
            return this.$page.props.auth.user.username;
        },
        category(){
            return this.$page.props.category;
        },
        categories(){
            return this.$page.props.categories.all_children_categories;
        }
    }
};
</script>