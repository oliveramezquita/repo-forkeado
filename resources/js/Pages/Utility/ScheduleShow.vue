<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "utility.schedule.show",
    },
});

</script>

<template>
    <Head title="Útiles" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Horario
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>