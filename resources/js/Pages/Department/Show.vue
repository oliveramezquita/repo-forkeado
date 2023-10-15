<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Title from '@/Components/Amadeus/Title.vue';
import Modal from '@/Components/Amadeus/Modal.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

import { permissions } from '@/utils/inertiaUtils';

import DepartmentElementTarget from '@/Pages/Department/Partials/DepartmentElementTarget.vue';

import DepartmentModal from '@/Pages/Department/Partials/DepartmentModal.vue';

const props = defineProps ({
    subjects: Array,
    departments: Array,
    teachers: Array,
    customroute: String,

    current_year: Object,
    edit_current_year: Boolean,
	current_syllabis: Array,

    next_year: Object,
    edit_next_year: Boolean,
    next_syllabis: Array,
});


</script>

<template>
    <Head title="Departamentos" />

    <AuthenticatedLayout :croute="customroute">

    <!-- Título y Pestañas -->
    <div class="header-section">
        <h1 class="page-title">Departamentos</h1>
        <h2 class="year-title"> 2023 / 2024 </h2>
    </div>

    

    <div class="mx-auto">

    <!-- Columna 1 -->
        <!-- Mostrando departamentos -->
        <div>
            <div v-for="department in departments" :key="department.id">
                <DepartmentElementTarget :obj="department" :teachers="teachers" metaname="Profesores" :subjects="subjects"/>
            </div>
        </div>
   
    <!-- Button trigger modal -->
    <div v-if="permissions.includes('department.store')">
        <a type="button" class="modal-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa-solid fa-circle-plus"></i>
        </a>
    </div>

            <Modal>
                <template #modal-header>
                    Crear Departamento
                </template>
                
                <template #modal-body>
                    <DepartmentModal :teachers="teachers" />
                </template>
            </Modal>

        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

.modal-btn {
    border-radius: 100%;
    bottom: 2rem;
    height: 4rem;
    position: fixed;
    right: 5rem;
    width: 4rem;
    transition: transform 0.3s ease;
}

.modal-btn:hover {
    transform: scale(1.05);
}


.fa-circle-plus {
    width: 100%;
    height: 100%;
    color: #3C7FF8;
    font-size: 4rem;
}

.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.page-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2B5DB6;
}

.year-title {
    border-radius: 3rem;
    height: 3.5rem;
    background-color: #3C7FF8;
    display: flex;
    justify-content: start;
    align-items: center;
    color: white;
    font-size: 1.1rem;
    padding: 1rem 1.8rem;
    font-weight: bold;
}



</style>