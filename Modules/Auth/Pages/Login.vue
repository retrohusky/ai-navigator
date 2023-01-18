<script setup>

import { useForm } from "@inertiajs/vue3";
import Errors from './Errors.vue';

const form = useForm({
    email: null,
    password: null,
});


</script>

<template>
    <Errors :form="form" />

    <form @submit.prevent="form.post('/login')">
        <label for="">
            <input v-model="form.email" type="text">
        </label>
        <label for="">
            <input v-model="form.password" type="password">
        </label>
        <button type="submit" :disabled="form.processing">Login</button>
    </form>
</template>
