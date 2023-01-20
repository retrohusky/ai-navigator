<script setup>
import {computed, defineProps} from "vue";

const { form } = defineProps({
    form: Object,
})

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
</template>
