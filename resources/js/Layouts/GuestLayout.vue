<script setup>
import ApplicationLogo from '@/Components/Amadeus/ApplicationLogo.vue';
import GridLayout from '@/Components/Custom/GridLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <GridLayout />

    <div class="min-h-screen flex flex-col md:flex-row md:justify-center items-center pt-6 sm:pt-0 main-content">
        <div>
            <Link href="/">
                <ApplicationLogo class="logo"/>
            </Link>
        </div>

        <div class="px-6 py-4 shadow-md overflow-hidden sm:rounded-lg form-container-custom">
            <slot />
        </div>
    </div>
    
</template>

<style>

.main-content {
    justify-content: center;
}

.logo {
    max-width: 33rem;
    height: 15rem;
    /* margin-right: 7rem; */

}

.form-container-custom {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    border-radius: 3.125rem;
    min-width: 33.5vw;
    min-height: 80vh;
    border: 1px solid #3C7FF8;
    background: linear-gradient(180deg, #FFF 0%, #B5CFFD 100%);
    margin-right: 4vw !important;
    margin-left: 6vw !important;
    box-shadow:0rem 0rem 1rem 0.5rem #00000015;
}

.main-content {
    justify-content: center;
    background-size: 150% 150%;
    animation: gradientShift 4s infinite alternate;
    background-image: 
        radial-gradient(circle at 10% 15%, #ffffff 0%, transparent 70%),
        radial-gradient(circle at 90% 85%, #f9fffe 0%, transparent 60%),
        radial-gradient(circle at 55% 55%, #b5fdf3 0%, transparent 40%),
        radial-gradient(circle at 20% 80%, #b8d0fb 0%, transparent 35%),
        radial-gradient(circle at 70% 20%, #B5CFFD 0%, transparent 45%);
}

@keyframes gradientShift {
    0% {
        background-position: 0% 0%;
    }
    25% {
        background-position: 50% 25%;
    }
    50% {
        background-position: 100% 50%;
    }
    75% {
        background-position: 50% 75%;
    }
    100% {
        background-position: 0% 100%;
    }
}
</style>