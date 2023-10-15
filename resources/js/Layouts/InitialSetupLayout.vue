<script setup>
import ApplicationLogo from '@/Components/Amadeus/ApplicationLogo.vue';
import GridLayout from '@/Components/Custom/GridLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <GridLayout />

    <div class="main-content d-flex flex-col align-items-center justify-content-around">
        <div>
            <h1 class="title">Configuración del Centro</h1>
        </div>

        <slot />
        
        <div>
            <ApplicationLogo class="logo"/>
        </div>
    </div>
    
</template>

<style scoped>

.title {
    color: #2B5DB6; 
    font-size: 1.8rem; 
    font-weight: 600; 
    margin-top: 2.5rem;
    margin-bottom: 2.5rem;
}

.main-content {
    min-height: 100vh;
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

.logo {
    max-width: 27rem;
    height: 12rem;
}
</style>