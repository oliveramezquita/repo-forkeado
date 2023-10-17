<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Amadeus/Modal.vue';
import NonCollapsableContainer from '@/Components/Amadeus/NonCollapsableContainer.vue';

import DegreeModal from '@/Pages/Syllabi/Partials/DegreeModal.vue';

import { permissions } from '@/utils/inertiaUtils';

const isHovered = ref(false);

const modalId = "updateDegreeSyllabi"

const props = defineProps({
    obj: Object,
});
/**
 * The emit updateObj is defined, a function found in the Elements.vue
 */
const emit = defineEmits(['updateObj']);

/**
 * Local function that emits the event
 */
const update = (obj) => {
    emit('updateObj', 'degree', 'Grado', obj, [])
}
</script>

<template>
    <div @mouseenter="isHovered = true" @mouseleave="isHovered = false" class="outer-wrapper">
        <NonCollapsableContainer :is-active="props.obj.is_active">
            <template #noncollapsablecontainer>
                <div class="content-wrapper">
                    <div>
                        <span class="target-text" :class="{ 'target-text-disabled': !props.obj.is_active }">{{
                            props.obj.name }}</span>
                    </div>

                    <div class="target-info" v-if="permissions.includes('degree.update')">
                        <!--
                            - The click event is added to the local update function
                            - The modal target is modified and now points to the single modal for modifications
                        -->
                        <a type="button" class="taget-info-edit" :class="{ specialHidden: !isHovered }"
                            @click="update(props.obj)" data-bs-toggle="modal" data-bs-target="#updateItemModal">
                            <i class="fa-regular fa-gear fa-spin"></i>
                        </a>
                    </div>
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