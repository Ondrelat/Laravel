<template>
  <nav class="text-white"> 
    <ul class="flex space-x-6">
      <li>
        <NavLink href="/" :active="$page.component === 'Home'">
          Accueil
        </NavLink>
      </li>
           <!-- 
      <li>
        <NavLink href="/users" :active="$page.component === 'Users'">
          Users
        </NavLink>
      </li>

      <li>
        <NavLink href="/settings" :active="$page.component === 'Settings'">
          Settings
        </NavLink>
      </li>
      -->
      <li v-if="username !== 'Vide'">
        <NavLink :href="`/TierList/ListeClassement/${$page.props.auth.user.username}`">
          Mes classements
        </NavLink>
      </li>
      <li v-if="username !== 'Vide'">
        <NavLink href="/logout" method="post" as="button">
          Déconnexion
        </NavLink>
      </li>
      <li v-if="username == 'Vide'">
        <NavLink href="/logout" method="post" as="button">
          Connexion
        </NavLink>
      </li>
      <li v-if="username == 'Vide'">
        <NavLink href="/Users/create" method="get" as="button">
          Créé un compte
        </NavLink>
      </li>
    </ul>
  </nav>
</template>

<script>
import NavLink from "./NavLink";

export default {
  components: { NavLink },

  computed: {
      username() {
      return this.$page.props.auth.user.username;
      }
  }
};
</script>