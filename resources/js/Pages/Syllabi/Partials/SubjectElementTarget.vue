<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Amadeus/Modal.vue';
import NonCollapsableContainer from '@/Components/Amadeus/NonCollapsableContainer.vue';

import { permissions } from '@/utils/inertiaUtils';

import SubjectModal from '@/Pages/Syllabi/Partials/SubjectModal.vue';

const isHovered = ref(false);

const modalId = "updateSubjectSyllabi"

const props = defineProps({
    obj: Object,
    departments: Object,
});
/**
 * The emit updateObj is defined, a function found in the Elements.vue
 */
const emit = defineEmits(['updateObj']);

/**
 * Local function that emits the event
 */
const update = (obj, dict) => {
    emit('updateObj', 'subject', 'Asignatura', obj, dict)
}
</script>

<template>
    <div @mouseenter="isHovered = true" @mouseleave="isHovered = false" class="outer-wrapper">

        <NonCollapsableContainer :is-active="props.obj.is_active">

            <template #noncollapsablecontainer>
                <div class="centered-container">
                    <span class="target-text" :class="{ 'target-text-disabled': !props.obj.is_active }">
                        {{ props.obj.name }}
                    </span>
                    <span v-if="props.obj.is_active === false" class="text-danger ml-4 disabled"></span>
                    <span class="target-subtext">
                        {{ props.obj.is_collective ? 'Colectiva' : 'Individual' }}
                    </span>
                </div>

                <div class="target-info centered-container">
                    <!--
                        - The click event is added to the local update function
                        - The modal target is modified and now points to the single modal for modifications
                    -->
                    <a v-if="permissions.includes('subject.update')" type="button" class="taget-info-edit"
                        :class="{ specialHidden: !isHovered }" @click="update(props.obj, props.departments)"
                        data-bs-toggle="modal" data-bs-target="#updateItemModal">
                        <i class="fa-regular fa-gear fa-spin"></i>
                    </a>
                </div>
            </template>

        </NonCollapsableContainer>
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
    right: -2rem;
    /* Ajusta este valor según lo lejos que quieras que esté el ícono de la tarjeta */
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
    padding-right: rem;
    /* Igual al padding original de container-target, para mantener el espacio */
}
</style>