<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "teacher.diary.show",
    },
});

</script>

<template>
    <Head title="Profesorado" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Cuaderno del profesor
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>