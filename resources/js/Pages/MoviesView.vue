<script setup>
import { ref, onMounted } from "vue";

let movies = ref([]);

const fetchMovies = async () => {
    try {
        const token = localStorage.getItem('access_token'); // Retrieve the token from localStorage
        const response = await fetch("/api/v1/movies", {
            method: "GET",
            headers: {
                "Accept": "application/json",
                "Authorization": `Bearer ${token}` // Include JWT token
            }
        });

        if (response.ok) {
            const data = await response.json();
            movies.value = data; // Update the reactive property with the fetched data
        } else {
            console.error("Failed to fetch movies:", response.statusText);
        }
    } catch (error) {
        console.error("Error fetching movies:", error);
    }
};

onMounted(() => {
    fetchMovies(); // Fetch movies when the component is mounted
});
</script>

<template>
    <div class="movies-container">
        <h1 class="mb-4">Movies</h1>
        <div class="row">
            <div v-for="movie in movies" :key="movie.id" class="col-md-4 mb-4">
                <div class="card">
                    <img :src="`/storage/${movie.poster}`" class="card-img-top" alt="Movie Poster" />
                    <div class="card-body">
                        <h5 class="card-title">{{ movie.title }}</h5>
                        <p class="card-text">{{ movie.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>