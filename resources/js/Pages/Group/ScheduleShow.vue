<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "group.schedule.show",
    },
});

</script>

<template>
    <Head title="Grupos" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Cambiar de fecha los grupos
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>