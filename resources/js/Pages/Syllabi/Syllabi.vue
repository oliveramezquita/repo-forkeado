<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

import SyllabiElementTarget from '@/Pages/Syllabi/Partials/SyllabiElementTarget.vue';

import { permissions } from '@/utils/inertiaUtils';

const props = defineProps ({
    current_year: Object,
    edit_current_year: Boolean,
	current_syllabis: Array,

    next_year: Object,
    edit_next_year: Boolean,
    next_syllabis: Array,
    
    customroute: String,
});

const activeTab = ref('current');

const scrollFilters = (direction) => {
    const container = document.querySelector('.filters-container');
    const width = container.offsetWidth;

    if (direction === 'right') {
        container.scrollLeft += width;
    } else if (direction === 'left') {
        container.scrollLeft -= width;
    }

    updateArrowsVisibility(container);
}


const updateArrowsVisibility = (container) => {
    // Verificar si hay contenido a la izquierda
    if (container.scrollLeft > 0) {
        showLeftArrow.value = true;
    } else {
        showLeftArrow.value = false;
    }

    // Verificar si hay contenido a la derecha
    const maxScrollLeft = container.scrollWidth - container.clientWidth;
    if (container.scrollLeft < maxScrollLeft) {
        showRightArrow.value = true;
    } else {
        showRightArrow.value = false;
    }
}


const showLeftArrow = ref(false);
const showRightArrow = ref(true);


onMounted(() => {
    const container = document.querySelector('.filters-container');
    updateArrowsVisibility(container);

    container.addEventListener('scroll', () => {
        updateArrowsVisibility(container);
    });
});

const searchOpen = ref(false);


</script>

<template>
    <Head title="Plan de estudios" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">

            <!-- Título y Pestañas -->
            <div class="header-section">
                <h1 class="page-title">Plan de Estudios</h1>

                <div class="tabs-container">
                    <div class="tabs">
                        <button @click="activeTab = 'current'" 
                                :class="{ 'study-tab-active': activeTab === 'current' }" 
                                class="study-tabs-button">
                            {{ current_year.start_year }} / {{ current_year.end_year }}
                        </button>

                        <button v-if="props.next_year"
                                @click="activeTab = 'next'" 
                                :class="{ 'study-tab-active': activeTab === 'next' }" 
                                class="study-tabs-button">
                            {{ next_year.start_year }} / {{ next_year.end_year }}
                        </button> 
                    </div>
                </div>
            </div>

                <!-- Aquí es donde deberías colocar la barra de filtros -->
            <div class="filter-bar">
                <input v-if="searchOpen" type="text" placeholder="Buscar..." class="search-input">

                <div class="filter-icon" @click="searchOpen = !searchOpen">
                    <i class="fa-regular fa-search"></i>
                </div>
                <div class="scroll-button left" @click="() => scrollFilters('left')" v-if="showLeftArrow">
                    <i class="fa-regular fa-chevron-left"></i>
                </div>
                
                <div class="filters-container">
                    <select class="filter-option">
                        <option>Grado</option>
                        <!-- Otras opciones... -->
                    </select>
                    <select class="filter-option">
                        <option>Curso</option>
                        <!-- Otras opciones... -->
                    </select>
                    <select class="filter-option">
                        <option>Especialidad</option>
                        <!-- Otras opciones... -->
                    </select>
                    <select class="filter-option">
                        <option>Asignatura</option>
                        <!-- Otras opciones... -->
                    </select>

                    <select class="filter-option">
                        <option>Esta es solo la de prueba</option>
                        <!-- Otras opciones... -->
                    </select>

                    <select class="filter-option">
                        <option>La de prueba 2</option>
                        <!-- Otras opciones... -->
                    </select>

                    <select class="filter-option">
                        <option>La de prueba 3</option>
                        <!-- Otras opciones... -->
                    </select>

                    <select class="filter-option">
                        <option>La de prueba 4</option>
                        <!-- Otras opciones... -->
                    </select>

                    <select class="filter-option">
                        <option>La de prueba 5</option>
                        <!-- Otras opciones... -->
                    </select>

                </div>

                <div class="scroll-button" @click="() => scrollFilters('right')">
                    <i class="fa-regular fa-chevron-right"></i>
                </div>

            </div>


            <!-- Shows syllabis of current year -->
            <div v-if="activeTab === 'current'">
                <div v-for="syllabi in current_syllabis" :key="syllabi.id">
                    <SyllabiElementTarget :obj="syllabi" :edit="edit_current_year"/>
                </div>
            </div>

            <!-- Shows syllabis of next year -->
            <div v-if="activeTab === 'next' && next_year">
                <div v-for="syllabi in next_syllabis" :key="syllabi.id">
                    <SyllabiElementTarget :obj="syllabi" :edit="edit_next_year" />
                </div>
            </div>

            <div v-if="permissions.includes('syllabi.store')">
                <!-- If either the current year or next year can be editted, then we show the add button -->
                <div v-if="activeTab === 'current' && edit_current_year">
                    <a type="button" class="modal-btn" :href="route('syllabi.create')">
                        <i class="fa-solid fa-circle-plus"></i>
                    </a>
                </div>
                <div v-if="activeTab === 'next' && edit_next_year">
                    <a type="button" class="modal-btn" :href="route('syllabi.create')">
                        <i class="fa-solid fa-circle-plus"></i>
                    </a>
                </div>
            </div>

        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

.amadeus-box {
    background: #3C7FF8;
    border-radius: 2rem;
    font-size: 1.5rem;
	color: #fff;
    font-weight: 800;
    font-size: 2.5rem;
    text-align: center;
}

.modal-btn {
    border-radius: 100%;
    bottom: 2rem;
    height: 4rem;
    position: fixed;
    right: 5rem;
    width: 4rem;
    transform: scale(1); /* Tamaño inicial sin escala adicional */
    transition: transform ease-in-out 0.15s; /* Transición para la transformación */
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
    margin-bottom: 2rem;
}

.page-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2B5DB6;
}

.study-tabs-button {
    padding: 1rem 1.8rem;
    background-color: transparent; /* Sin fondo */
    color: #2B5DB6; /* Texto azul oscuro */
    border-radius: 3rem;
    font-size: 1.1rem;
    cursor: pointer;
    border: none; /* Asegurándonos de que no haya bordes */
    outline: none; /* Eliminamos el resplandor al hacer clic */
    transition: background-color 0.3s; /* Transición suave al cambiar de color */
}

/* Estilo para botón de pestaña activa */
.study-tab-active {
    background-color: #3C7FF8; /* Fondo azul */
    color: #fff; /* Texto blanco */
    font-weight: bold; /* Texto en negrita */
}

/* Efecto hover para botones de las pestañas */
.study-tabs-button:hover {
    color: #3C7FF8;
}

.study-tabs-button.study-tab-active:hover {
    color: white; /* O el color que desees */
    cursor: default; /* Cambia el cursor cuando se pasa el mouse sobre el botón */
}

.tabs-container {
    border-radius: 3rem;
    height: 3.5rem;
    background-color: #ECECEC;
    display: flex;
    justify-content: start;
    align-items: center;
}

.filter-bar {
    display: flex;
    justify-content: space-between; /* Distribuir elementos a lo largo de la barra */
    align-items: center;
    padding: 1rem;
}

.filter-icon {
    color: #2B5DB6;
    /* Estilos para el icono, si es necesario */
}

.filters-container {
    display: flex;
    overflow-x: auto; /* Hacerlo desplazable horizontalmente */
    white-space: nowrap; /* Evitar el salto de línea */
}

.filter-option {
    margin: 0 1.2rem; /* Espaciado entre selectores */
}

.scroll-button {
    cursor: pointer;
    /* Estilos adicionales si es necesario */
}

.filter-option {
    border-radius: 3rem;
    border-color: #2B5DB6;
    color: #2B5DB6;
    font-size: 1.2rem;
    padding-right: 5.5rem;
    padding-left: 5rem;
    /* Estilos adicionales si es necesario */
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.filters-container::-webkit-scrollbar {
    display: none;
}

.filters-container {
    scroll-behavior: smooth;
    -ms-overflow-style: none;  /* para IE y Edge */
    scrollbar-width: none;    /* para Firefox */
}

.filter-icon {
    color: #2B5DB6;
    font-size: 1.5rem; /* o el tamaño que desees */
    margin-right: 1rem; /* o la separación que desees */
}

.scroll-button i {
    color: #2B5DB6;  /* Cambio de color del ícono */
}

.search-input {
    border: 1px solid #2B5DB6;
    padding: 0.5rem 1rem;
    border-radius: 3rem;
    font-size: 1rem;
    margin-right: 1rem;
    transition: width 0.3s ease-in-out;
    width: 30rem;
    flex-grow: 1;
    outline: none;
}

</style>