<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "messaging.show",
    },
});

</script>

<template>
    <Head title="Mensajería" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Mensajería
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>