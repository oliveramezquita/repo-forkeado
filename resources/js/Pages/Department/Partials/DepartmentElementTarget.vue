<script setup>
import { ref, onMounted, computed } from 'vue';
import Modal from '@/Components/Amadeus/Modal.vue';
const isActiveCollapse = ref(false);

import DepartmentModal from '@/Pages/Department/Partials/DepartmentModal.vue';
import AddSubjectDepartmentModal from '@/Pages/Department/Partials/AddSubjectDepartmentModal.vue';
import RemoveSubjectDepartmentModal from '@/Pages/Department/Partials/RemoveSubjectDepartmentModal.vue';

import { permissions } from '@/utils/inertiaUtils';

const isHovered = ref(false);

const updateDepartment = "updateDepartment";
const addSubject = "addSubject";
const removeSubject = "removeSubject";
const isAnimating = ref(false);

const handleBootstrapEvent = (event) => {
    event.stopPropagation();
};

const searchQuery = ref('');

const filteredSubjects = computed(() => {
  if (!searchQuery.value) return props.obj.subjects; // Si la cadena de búsqueda está vacía, retorna todos los elementos.
  
  return props.obj.subjects.filter(subject =>
    subject.name.toLowerCase().includes(searchQuery.value.toLowerCase()) // Si no, filtra los elementos basándote en la cadena de búsqueda.
  );
});



const props = defineProps ({
	obj: Object,
    metaname: String,
    teachers: Object,
    subjects: Object
});

// Mapeo de números a días de la semana
const daysOfWeek = {
    1: 'Lunes',
    2: 'Martes',
    3: 'Miércoles',
    4: 'Jueves',
    5: 'Viernes',
    6: 'Sábado',
    7: 'Domingo'
};

// Función para convertir un número en el día de la semana correspondiente
function getDayName(meeting_day) {
    return daysOfWeek[meeting_day] || 'Día desconocido';
}

const toggleCollapse = () => {
    if (isAnimating.value) return; // prevent further clicks if an animation is in progress
    isAnimating.value = true;

    isActiveCollapse.value = !isActiveCollapse.value;

    searchQuery.value = '';

}

onMounted(() => {
    const collapseTriggerElement = document.querySelector('.container-target.container-rounded');
    
    collapseTriggerElement.addEventListener('click', handleBootstrapEvent, true);

    const collapseElement = document.getElementById('collapse' + props.obj.id);
    
    collapseElement.addEventListener('shown.bs.collapse', () => {
        isAnimating.value = false;
        isActiveCollapse.value = true;
    });

    collapseElement.addEventListener('hidden.bs.collapse', () => {
        isAnimating.value = false;
        isActiveCollapse.value = false;
    });
});

const inChargeName = computed(() => {
  return props.obj.in_charge !== null ? props.obj.in_charge.name : '';
});

</script>

<template>
    <div class="container-fluid relative-container" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
        <div 
            class="container-target container-rounded" 
            @click="toggleCollapse"
            :class="{ 'isActiveCollapse': isActiveCollapse }"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="'#collapse' + props.obj.id"
            :aria-expanded="isActiveCollapse"
            :aria-controls="props.obj.id">
                <div class="target-text">
                    <span class="Department"> {{ props.obj.name }} </span>
                    <span class="Professor" v-if="props.obj.in_charge"> | {{ inChargeName }} </span>
                    <span> {{ getDayName(props.obj.meeting_day) }} - {{ props.obj.meeting_time.slice(0, -3) }} </span>
                    <span v-if="props.obj.is_active === false" class="text-danger ml-4 disabled">Desactivado</span>
                </div>
            <div class="target-info flex-row align-items-center">
                <div class="hours-count">
                    <span class="hours-number">
                        <i class="fa-light fa-circle-user"></i>
                        <strong>{{ props.obj.users }}</strong></span>
                    <span class="hours-label">{{ props.metaname }}</span>
                </div>
                <div class="target-info absolute-gear">
                    <a v-if="permissions.includes('department.update')" 
                    type="button" 
                    class="target-info-edit" 
                    :class="{ specialHidden: !isHovered }" 
                    data-bs-toggle="modal" 
                    :data-bs-target='"#" + updateDepartment + props.obj.id'>
                        <i class="fa-regular fa-gear fa-spin"></i>
                    </a>                 
                </div>
            </div>
        </div>

        <div class="container-collapse">
            <div class="collapse" :class="'collapse' + props.obj.id" :id="'collapse' + props.obj.id">
                <div class="container-header">
                    <div class="searchbar">
                        <input type="text" class="form-control" v-model="searchQuery">
                        <a><i class="fa-light fa-magnifying-glass"></i></a>
                        <a v-if="permissions.includes('department.subject.store')" type="button" data-bs-toggle="modal" :data-bs-target='"#" + addSubject + props.obj.id'>
                            <i class="fa-light fa-circle-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="container-body">
                     <table class="table-target">
                        <tbody>
                            <tr class="table-row" v-for="(subject, index) in filteredSubjects" :key="subject.id">
                                <td class="table-cell-number">{{ index + 1 }}.</td>
                                <td class="table-cell-text"> {{ subject.name }} <span v-if="subject.is_active === false" class="text-danger ml-4 disabled"></span> </td>
                                <td class="table-cell-icon">
                                    <a v-if="permissions.includes('department.subject.destroy')" type="button" data-bs-toggle="modal" :data-bs-target='"#" + removeSubject + props.obj.id + subject.id'>
                                        <i class="fa-regular fa-trash-can fa-bounce"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <Modal :id='updateDepartment + props.obj.id'>
        <template #modal-header>
            Actualizar Departamento
        </template>
        
        <template #modal-body>
                <DepartmentModal edit=true :obj="props.obj" :teachers="props.teachers"/>
        </template>
    </Modal>

    <Modal :id='addSubject + props.obj.id'>
        <template #modal-header>
            Añadir Asignatura
        </template>
        
        <template #modal-body>
                <AddSubjectDepartmentModal :currentsubjects="props.obj.subjects" :subjects="props.subjects" :id="props.obj.id"/>
        </template>
    </Modal>

    <div v-for="subject in props.obj.subjects" :key="subject.id">
        <Modal :id='removeSubject + props.obj.id + subject.id'>
            <template #modal-header>
                Eliminar asignatura
            </template>
            
            <template #modal-body>
                    <RemoveSubjectDepartmentModal :subject_id="subject.id" :id="props.obj.id" />
            </template>
        </Modal>
    </div>
</template>

<style scoped>
    .form-control {
        border: 1px solid #D3D6DC;
    }

    .collapse,
    .collapsing {
        width: 100%;
    }

    .show {
        visibility: visible;
    }

    .card-header {
        display: flex;
        flex-direction: row;
        padding: 1rem 7rem;
        align-items: center;
        background-color: #fff;
    }

    .container-target {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: transparent;
        min-height: 5.2rem;
        height: auto;
        padding: 0rem 9.5rem 0rem 6.5rem;
        box-shadow: 0px 0px 8px 0px rgba(0, 0, 0, 0.20);
        /* border-bottom: 4px solid #06aa27; */
        cursor: pointer;
    }

    .Department {
        color: #2B5DB6;
        font-weight: 600;
        font-size: 1.4rem;
    }
    .Professor {
        color: #0C0C0C;
        font-weight: 500;
        font-size: 1.15rem;
        padding-right: 1rem;
        
    }

    .target-info {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        padding-right: rem;
    }

    .container-collapse {
        display: flex;
        border-bottom-right-radius: 3rem;
        border-bottom-left-radius: 3rem;
        box-shadow: 0px 2px 6px 0px rgba(0, 0, 0, 0.20);
    }

    .isActiveCollapse {
        border-top-left-radius: 3rem;
        border-top-right-radius: 3rem;
        border-bottom-right-radius: 0rem;
        border-bottom-left-radius: 0rem;
        margin: 0rem 0rem;
    
    }



    .searchbar {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 97%;
        position: relative;
        height: 3rem;
        padding-left: 8rem;
    }

    .searchbar input {
        width: 100%;
        height: 100%;
        display: absolute;
        font-size: 1.3rem;
        padding-right: 7rem;
        border-radius: 8rem;
        padding-left: 2rem;
    }

    .searchbar input:focus {
        box-shadow: none;
    }

    .searchbar .fa-magnifying-glass {
        position: absolute;
        top: .8rem;
        right: 6.5rem;
        font-size: 1.4rem;
        color: #2B5DB6;
        cursor: pointer;
    }

    .container-header .fa-circle-plus {
        margin-left: 2rem;
        font-size: 2.5rem;
        color: #2B5DB6;
        cursor: pointer;
    }

    .container-header{
        width: 100%;
        margin: auto;
        padding: 1rem 5rem;
    }

    .container-body{
        border-bottom-right-radius: 6rem;
        border-bottom-left-radius: 6rem;
        padding-top: 0rem;
    }

    .target-info-edit {
        margin-left: 3rem;
        cursor: pointer;
        font-size: 1.4rem;
        color: var(--color-primary);
    }

    .target-info-edit.specialHidden {
        opacity: 0;
    }

    .table-target {
    width: 100%; /* Hace que la tabla ocupe todo el ancho disponible */
    border-collapse: separate; /* Esto asegura que las celdas están separadas */
    padding-bottom: 0.4rem;
    }

.table-row {
    display: flex;
    justify-content: space-between; 
    align-items: center; 
    border-bottom: 1px solid #AEC4E5;
    padding: 0.9rem 0; /* puedes ajustar el padding superior e inferior para modificar la altura entre cada fila */
}

.table-row:last-child {
    border-bottom: none;
}

.table-cell-number, .table-cell-text, .table-cell-icon {
    flex: 1; 
}
    .table-cell-text {
        text-align: left; /* Alineación al centro (o a la izquierda si lo prefieres) */
        padding: 0rem 0rem 0rem; /* Espacio a ambos lados para separar del número y del ícono */
    }

    .table-cell-icon {
        text-align: right; /* Alineación a la derecha */
        opacity: 0; /* Ícono invisible inicialmente */
        transition: opacity 0.3s; /* Efecto suave al hacer visible el ícono */
        margin-right: 7.8rem;
        color: #2B5DB6;
    }

    .table-row:hover .table-cell-icon {
        opacity: 1; /* Ícono visible al pasar el ratón por encima */
    }

    .hours-count {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    margin-right: -3rem;
    }

    .hours-number, .hours-label {
        text-align: right;
    }

    .fa-light.fa-circle-user {
        margin-right: 0.2rem;
    }

    .table-cell-number {
        margin-left: 6.5rem;
        font-weight: 500;
    }

    .table-cell-text {
        font-weight: 400;
        margin-right: 22rem;
    }

    .relative-container {
        position: relative;
        transition: transform 0.3s ease;  /* Añadir transición */
    }

    .relative-container:hover {
        transform: scale(1.03);  /* Escala al pasar el mouse */
    }

    .absolute-gear {
        position: absolute;
        right: -1.5rem; /* Puedes ajustar según tus necesidades */
        top: 50%;
        transform: translateY(-50%); /* Centra verticalmente el elemento */
    }

    /* Asegúrate de añadir un z-index adecuado para que el ícono aparezca por encima de otros elementos si es necesario */
    .absolute-gear .target-info-edit {
        z-index: 10;
        color: #2B5DB6;
    }

    .container-fluid {
        padding-top: 1rem;
    }

  

</style> 