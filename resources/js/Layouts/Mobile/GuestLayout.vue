<script setup>
import ApplicationLogo from '@/Components/Amadeus/ApplicationLogo.vue';
import GridLayout from '@/Components/Custom/GridLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <GridLayout />

    <div class="min-h-screen flex flex-column justify-center items-center">
        <div class="flex flex-colum justify-center text-center px-6 py-4 shadow-md overflow-hidden rounded-lg form-container-custom">
            <slot />
        </div>

        <div>
            <Link href="/">
                <ApplicationLogo class="logo"/>
            </Link>
        </div>
    </div>
    
</template>

<style>

.logo {
    max-width: 12rem;
    height: 15rem;
}

.form-container-custom {
    border-radius: 3.125rem;
    min-width: 33.5vw;
    min-height: 80vh;
    border: 1px solid #3C7FF8;
    background: linear-gradient(180deg, #FFF 0%, #B5CFFD 100%);
    box-shadow:0rem 0rem 1rem 0.5rem #00000015;
}
</style>