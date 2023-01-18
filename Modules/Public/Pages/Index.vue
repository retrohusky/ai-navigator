<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const auth = computed(() => usePage().props.auth);

</script>

<template>
    <h1>Welcome to AI Navigator.</h1>

    <Link v-if="auth" href="/logout" method="post" as="button" type="button">Logout</Link>
</template>
