<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "student.show",
    },
    students: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <Head title="Grupos" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Lista alumnos
            <div v-for="student in students" :key="student.id">
                <div class="shadow-sm sm:rounded-lg amadeus-box">
                    <div class="p-5"> <img :src=student.photo_url class="w-20 rounded"> {{ student.name }} <span v-if="student.guardian"> - {{ student.guardian.name }}</span></div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>