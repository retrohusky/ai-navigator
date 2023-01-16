<script setup>

import { useForm } from "@inertiajs/vue3";

const form = useForm({
    username: null,
    email: null,
    password: null,
    confirmPassword: null,
});

const handle = () => {
    form.post('/register', {
        preserveScroll: true,
    })
}

</script>

<template>
    <div v-if="form.errors">
        <p>There are some problems with your form submissions:</p>
        <ul>
            <li v-for="error in form.errors">
                {{ error }}
            </li>
        </ul>
    </div>
    <form @submit.prevent="form.post('/register')">
        <label for="">
            <input v-model="form.username" type="text">
        </label>
        <label for="">
            <input v-model="form.email" type="text">
        </label>
        <label for="">
            <input v-model="form.password" type="password">
        </label>
        <label for="">
            <input v-model="form.confirmPassword" type="password">
        </label>
        <button type="submit" :disabled="form.processing">Register</button>
    </form>
</template>
