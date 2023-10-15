<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "evaluation.statistic.show",
    },
});

</script>

<template>
    <Head title="Evaluación" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Estadísticas
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>