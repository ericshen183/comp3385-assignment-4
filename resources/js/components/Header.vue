<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const isAuthenticated = ref(false); // Reactive property to track authentication status

const checkAuth = () => {
    isAuthenticated.value = !!localStorage.getItem('access_token'); // Check if token exists
};

const logout = async () => {
    const token = localStorage.getItem('access_token'); // Retrieve the JWT token from localStorage
    try {
        const response = await fetch('/api/v1/logout', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}` // Include the JWT token in the Authorization header
            }
        });

        if (response.ok) {
            localStorage.removeItem('access_token'); // Remove the token from localStorage
            isAuthenticated.value = false; // Update authentication status
            alert('Logged out successfully!');
            router.push('/login'); // Redirect the user to the login page
        } else {
            alert('Failed to log out. Please try again.');
        }
    } catch (error) {
        console.error('Error during logout:', error);
        alert('An error occurred. Please try again.');
    }
};

onMounted(() => {
    checkAuth(); // Check authentication status when the component is mounted
});
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">COMP3385</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/'}" to="/">Home</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/about'}" to="/about">About</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/movies'}" to="/movies">Movies</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/movies/create'}" to="/movies/create">Add Movie</RouterLink>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li v-if="!isAuthenticated" class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/login'}" to="/login">Login</RouterLink>
                    </li>
                    <li v-if="isAuthenticated" class="nav-item">
                        <button class="btn btn-link nav-link" @click="logout">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.navbar .btn-link {
    color: #fff;
    text-decoration: none;
    padding: 0;
}
.navbar .btn-link:hover {
    text-decoration: underline;
}
</style>
