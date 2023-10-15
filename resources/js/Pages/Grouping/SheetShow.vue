<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "grouping.sheet.show",
    },
});

</script>

<template>
    <Head title="Agrupaciones" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Partituras de agrupaciones
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>