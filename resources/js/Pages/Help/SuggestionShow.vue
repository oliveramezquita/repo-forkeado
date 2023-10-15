<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "help.suggestion.show",
    },
});

</script>

<template>
    <Head title="Personal" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Sugerencias
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>