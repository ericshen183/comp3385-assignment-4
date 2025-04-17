import { createRouter, createWebHistory } from 'vue-router';
import AboutView from "../Pages/AboutView.vue";
import HomeView from "../Pages/HomeView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            component: HomeView
        },
        {
            path: '/about',
            component: AboutView
        },
        {
            path: '/movies/create',
            component: () => import('../Pages/AddMovieView.vue')
        },
        {
            path: '/movies', // New route for MoviesView
            component: () => import('../Pages/MoviesView.vue')
        },
        {
            path: '/login',
            component: () => import('../Pages/LoginView.vue')
        }
    ]
});

export default router;
