<script setup>

import { useForm } from "@inertiajs/vue3";
import { computed } from 'vue';

const form = useForm({
    username: null,
    email: null,
    password: null,
    confirmPassword: null,
});

const hasErrors = computed(() => {
    return !_.isEmpty(form.errors);
});

</script>

<template>
    <div v-if="hasErrors">
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
