<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const form = ref({
    email: '',
    password: ''
});

const login = async () => {
    try {
        const response = await fetch('/api/v1/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(form.value)
        });

        const data = await response.json();

        if (response.ok) {
            localStorage.setItem('access_token', data.access_token); // Store the JWT token
            alert('Login successful!');
            router.push('/movies'); // Redirect to the movies page
        } else {
            console.error('Login failed:', data);
            alert(data.error || 'Login failed. Please try again.');
        }
    } catch (error) {
        console.error('Error during login:', error);
        alert('An error occurred. Please try again.');
    }
};
</script>

<template>
    <div class="login-container">
        <h1 class="mb-4">Login</h1>
        <form @submit.prevent="login" class="login-form">
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" v-model="form.email" name="email" class="form-control" required />
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" v-model="form.password" name="password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</template>

<style scoped>
.login-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.login-form .form-group {
    margin-bottom: 15px;
}

.login-form .btn {
    width: 100%;
}
</style>