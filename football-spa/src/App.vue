<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import { useAuthStore } from '@/stores/auth.ts';
// import { useFetch } from "@/hooks/useFetch.ts";

const authStore = useAuthStore();
const { tokensExist, clearTokens } = authStore;

async function logout() {
  // const { status } = await useFetch('/proxy/api/logout', {
  //   method: 'POST',
  // }, true);
  //
  // if (204 === status.value) {
    clearTokens();
  // }
}

</script>

<template>
  <header>
    <div class="wrapper">
      <nav v-if="tokensExist">
        <button @click.prevent="logout" >
          Salir
        </button>
        <RouterLink to="/competitions">Competiciones</RouterLink>
        <RouterLink to="/teams">Equipos</RouterLink>
        <RouterLink to="/players">Jugadores</RouterLink>
      </nav>
    </div>
  </header>

  <RouterView />
</template>

<style scoped>
nav {
  width: 100%;
  font-size: 24px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
