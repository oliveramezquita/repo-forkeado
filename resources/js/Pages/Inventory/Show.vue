<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps ({
    customroute: {
        type: String,
        default: () => "inventory.show",
    },
    items: {
        type: Array,
        default: () => [],
    },
    loan_agreement: {
        type: String,
        default: () => "",
    }
});

</script>

<template>
    <Head title="Inventario" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Lista de inventario
            <div v-for="item in items" :key="item.id">
                <div class="shadow-sm sm:rounded-lg amadeus-box">
                    <div class="p-5"> {{ item.type }} {{ item.name }} {{ item.brand }} {{ item.status }}</div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>