<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "staff.substitution.show",
    },
    substitutions: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <Head title="Personal" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Sustituciones
            <div v-for="substitution in substitutions" :key="substitution.id">
                <div class="shadow-sm sm:rounded-lg amadeus-box">
                    <div class="p-5"> <img :src=substitution.photo_url class="w-20 rounded">  {{ substitution.name }} {{ substitution.surname }} - {{ substitution.state }}</div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>