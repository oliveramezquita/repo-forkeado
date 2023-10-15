<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "utility.calendar.show",
    },
});

</script>

<template>
    <Head title="Útiles" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Calendario
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>