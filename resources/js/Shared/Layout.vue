<template>
<div class="h-screen">
  <Head>
    <title>Home</title>
    <meta
      type="description"
      content="Home information"
      head-key="description"
    >
  </Head>

    <section class="p-4 bg-gray-800">
        <header class="flex justify-between">
            <div class="flex items-center">
                <p v-if="username !== 'Vide'" class="text-sm ml-4 text-white">Bienvenue, {{ username }}!</p>
            </div>
            <Nav />
        </header>
    </section>
    <section>
        <div class="max-w-3xl mx-auto">
            <slot />
        </div>
    </section>

</div>
</template>

<script>
import Nav from "./Nav"
import SideNav from "./SideNav"

export default {

    components:{ Nav, SideNav },

    computed: {
        username() {
        return this.$page.props.auth.user.username;
        }
    }
};
</script>