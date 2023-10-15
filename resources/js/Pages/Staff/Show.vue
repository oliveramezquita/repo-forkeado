<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "staff.show",
    },
    teachers: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <Head title="Personal" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Lista de profesores
            <div v-for="teacher in teachers" :key="teacher.id">
                <div class="shadow-sm sm:rounded-lg amadeus-box">
                    <div class="p-5"> <img :src=teacher.photo_url class="w-20 rounded"> {{ teacher.name }} {{ teacher.surname }} - <span v-if="teacher.positions" v-for="position in teacher.positions"> {{ position.name }}</span></div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>