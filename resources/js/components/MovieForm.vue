<template>
    <form id="movieForm" @submit.prevent="saveMovie" class="movie-form">
        <div class="form-group mb-3">
            <label for="title" class="form-label">Movie Title</label>
            <input type="text" v-model="form.title" name="title" class="form-control" required/>
        </div>
        <div class="form-group mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea v-model="form.description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="poster" class="form-label">Poster</label>
            <input type="file" @change="handleFileUpload" name="poster" class="form-control" accept="image/*" required/>
        </div>
        <button type="submit" class="btn btn-primary">Submit Movie</button>
    </form>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
    title: '',
    description: '',
    poster: null
});

const handleFileUpload = (event) => {
    form.value.poster = event.target.files[0];
};

const saveMovie = async () => {
    const formData = new FormData();
    formData.append('title', form.value.title);
    formData.append('description', form.value.description);
    formData.append('poster', form.value.poster);

    try {
        const response = await fetch("/api/v1/movies", { // Updated URL to include /api prefix
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok) {
            console.log('Success:', data);
            alert('Movie created successfully!');
        } else {
            console.error('Error:', data);
            alert('Failed to create movie: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while submitting the form.');
    }
};
</script>