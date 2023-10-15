<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import GroupElementTarget from '@/Pages/Group/Partials/GroupElementTarget.vue';

// No es necesario importar ref y computed si no los estás usando.

// Define props
const { customroute, groups } = defineProps({
    customroute: {
        type: String,
        default: () => "group.show",
    },
    groups: {
        type: Array,
        default: () => [],
    },
});

// Definición temporal de las variables, reemplaza estos valores con los reales.
const tuDataObjeto = {};
const tuMetaname = "Metaname de ejemplo";
const tusTeachers = [];
const tusSubjects = [];
</script>

<template>
    <Head title="Grupos" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            <div class="header-section">
                <h1 class="page-title">Grupos</h1>
            </div>

            <div v-for="group in groups" :key="group.id">
                <GroupElementTarget :obj="group" />
            </div>

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
