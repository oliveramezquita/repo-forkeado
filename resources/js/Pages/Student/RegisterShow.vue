<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "student.register.show",
    },
});

</script>

<template>
    <Head title="Grupos" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Nueva alta de alumno
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>