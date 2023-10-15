<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "student.request.show",
    },
});

</script>

<template>
    <Head title="Grupos" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Solicitudes alumnos
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>