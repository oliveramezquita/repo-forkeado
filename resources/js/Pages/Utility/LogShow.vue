<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "utility.log.show",
    },
    logs: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <Head title="Útiles" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Historial de registro
            <div v-for="log in logs" :key="log.id">
                <div class="shadow-sm sm:rounded-lg amadeus-box">
                    <div class="p-5"> {{ log.user.name }} {{ log.user.surname }}, {{ log.model }} - {{ log.hour }} {{ log.date }}</div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>