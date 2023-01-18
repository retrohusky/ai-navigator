<script setup>

import { useForm } from "@inertiajs/vue3";
import Errors from './Errors.vue';

const form = useForm({
    username: null,
    email: null,
    password: null,
    confirmPassword: null,
});

</script>

<template>
    <Errors :form="form" />

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
