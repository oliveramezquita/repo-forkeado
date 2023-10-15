<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "utility.repository.show",
    },
    folders: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <Head title="Útiles" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Repositorio
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>