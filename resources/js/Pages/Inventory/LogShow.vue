<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "inventory.log.show",
    },
});

</script>

<template>
    <Head title="Inventario" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Historial de inventario
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>