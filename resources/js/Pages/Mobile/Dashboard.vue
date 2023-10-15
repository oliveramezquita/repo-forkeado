
<script setup>
import AuthenticatedLayout from '@/Layouts/Mobile/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "dashboard",
    },
    data: {
        type: Array,
        default: () => [],
    },
    events: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <Head title="Inicio" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            <div class="shadow-sm sm:rounded-lg amadeus-box">
                <div class="p-5">¡Bienvenido a Amadeus Móvil!</div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

.amadeus-box {
    background: #3C7FF8;
    border-radius: 2rem;
    font-size: 1.5rem;
	color: #fff;
    font-weight: 800;
    font-size: 2.5rem;
    text-align: center;
}

</style>