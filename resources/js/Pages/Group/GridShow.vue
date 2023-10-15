<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "group.grid.show",
    },
});

</script>

<template>
    <Head title="Grupos" />

    <AuthenticatedLayout :croute="customroute">
        

        <div class="mx-auto">
            Cuadrante de grupos
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2B5DB6;
}

</style>