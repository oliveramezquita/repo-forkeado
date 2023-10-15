<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Amadeus/Modal.vue';
import NonCollapsableContainer from '@/Components/Amadeus/NonCollapsableContainer.vue';

import CourseModal from '@/Pages/Syllabi/Partials/CourseModal.vue';

import { permissions } from '@/utils/inertiaUtils';

const isHovered = ref(false);

const modalId = "updateCourseSyllabi"

const props = defineProps ({
	obj: Object,
    coursesDict: Array,
});

</script>

<template>
    <div @mouseenter="isHovered = true" @mouseleave="isHovered = false" class="outer-wrapper">
        
        <NonCollapsableContainer :is-active="props.obj.is_active">
            
            <template #noncollapsablecontainer>
                <div>
                    <span class="target-text" :class="{ 'target-text-disabled': !props.obj.is_active }">
                        {{ props.obj.name }}
                    </span>
                    <span v-if="props.obj.is_active === false" class="text-danger ml-4 disabled"></span>
                </div>
                
                <div class="target-info">
                    <a v-if="permissions.includes('course.update')" 
                       type="button" 
                       class="taget-info-edit" 
                       :class="{ specialHidden: !isHovered }" 
                       data-bs-toggle="modal" 
                       :data-bs-target='"#" + modalId + props.obj.id'>
                        <i class="fa-regular fa-gear fa-spin"></i>
                    </a>
                </div>
            </template>
        
        </NonCollapsableContainer>

        <Modal :id='modalId + props.obj.id'>
            <template #modal-header>
                Actualizar Curso
            </template>
            
            <template #modal-body>
                <CourseModal edit=true :obj="props.obj" :coursesDict="props.coursesDict" />
            </template>
        </Modal>
    </div>
</template>


<style scoped>

.outer-wrapper {
    align-items: center; 
    /* Aquí puedes añadir más estilos si es necesario para ajustar la posición y el diseño */
}


.relative-container {
    position: relative;
}

.taget-info-edit {
    position: absolute;
    right: -2rem; /* Ajusta este valor según lo lejos que quieras que esté el ícono de la tarjeta */
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 1.4rem;
    color: #2B5DB6;
}


.taget-info-edit.specialHidden {
    opacity: 0;
}

.target-text {
    color: #2B5DB6;
    font-weight: 600;
    font-size: 1.4rem;
    margin-right: 2rem;
    
}

.target-text-disabled {
    color: #5c5b68;
    font-weight: 600;
    font-size: 1.4rem;
    margin-right: 2rem;
}

.content-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding-right: rem; /* Igual al padding original de container-target, para mantener el espacio */
    }


</style>