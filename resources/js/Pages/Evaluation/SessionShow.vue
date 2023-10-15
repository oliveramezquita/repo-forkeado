<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "evaluation.session.show",
    },
});

</script>

<template>
    <Head title="Evaluación" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Sesión de evaluación
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>