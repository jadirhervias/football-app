import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import TeamsView from "@/views/TeamsView.vue";
import CompetitionsView from "@/views/CompetitionsView.vue";
import PlayersView from "@/views/PlayersView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/competitions',
      name: 'competitions',
      component: CompetitionsView,
    },
    {
      path: '/teams',
      name: 'teams',
      component: TeamsView,
    },
    {
      path: '/players',
      name: 'players',
      component: PlayersView,
    },
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue'),
    // },
  ],
})

export default router
