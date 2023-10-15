<script setup>
import ApplicationLogo from '@/Components/Amadeus/ApplicationLogo.vue';
import GridLayout from '@/Components/Custom/GridLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <GridLayout />

    <div class="main-content d-flex flex-col align-items-center justify-content-around">
        <div class="d-flex flex-row justify-content-around">
            <div>
                <Link href="/">
                    &lt;
                </Link>
            </div>
            <div>Matriculación</div>
        </div>
        
        <slot />
        
        <div>
            <Link href="/">
                <ApplicationLogo class="logo"/>
            </Link>
        </div>
    </div>
    
</template>

<style>

.logo {
    max-width: 33rem;
    height: 15rem;
}

.main-content {
    /* height: 100vh; */
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