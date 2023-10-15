<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-3 text-left text-md leading-5 transition duration-150 ease-in-out hover-custom"
        style="color: #2b5db6; font-size: 1.05rem; text-decoration: none;"
        >
        <slot />
    </Link>
</template>

<style scoped>

:hover.hover-custom{
    font-weight: 700;
}

</style>