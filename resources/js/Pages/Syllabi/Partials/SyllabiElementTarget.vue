<script setup>
import { ref } from 'vue';
const isActiveCollapse = ref(false);

import { permissions } from '@/utils/inertiaUtils';

const isHovered = ref(false);

const props = defineProps ({
	obj: Object,
    edit: Boolean,
});


</script>

<template>

    
    
    <div class="container-fluid" @mouseenter="isHovered = true" @mouseleave="isHovered = false">


        <div 
            class="container-target container-rounded" 
            @click="isActiveCollapse = !isActiveCollapse"
            :class="{ isActiveCollapse }"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="'#collapse' + props.obj.id"
            :aria-expanded="isActiveCollapse"
            :aria-controls="props.obj.id">
            
            <div class="target-text">
                <span> {{ props.obj.course }}º | {{ props.obj.degree }} </span>
                <span v-if="props.obj.name"> ({{ props.obj.name }}) </span>
                <span v-if="props.obj.is_active === false" class="text-danger ml-4 disabled">Desactivado</span>
            </div>

            <div class="target-info">
                <div class="badges-container">
                    <span v-if="props.obj.specialities.length > 0" v-for="speciality in props.obj.specialities" :key="speciality.id" class="badge mx-1">
                        {{ speciality.name }}
                    </span>
                    <span v-else class="badge mx-1">
                        Sin especialidades
                    </span>
                </div>
            </div>

            <div class="gear-container" v-if="permissions.includes('syllabi.update') && edit">
                <a type="button" class="target-info-edit" :class="{ specialHidden: !isHovered }" :href="route('syllabi.edit', { syllabi: props.obj })">
                    <i class="fa-regular fa-gear fa-spin"></i>
                </a>
            </div>
        </div>

        <div class="container-collapse">
            <div class="collapse" :class="'collapse' + props.obj.id" :id="'collapse' + props.obj.id">
                <div class="container-body">
                    <div class="table-container">
                        <table class="table-target">
                            <tbody>
                                <tr>
                                    <!-- <th class="table-header-number">#</th> -->
                                    <th class="table-header-text">Asignatura</th>
                                    <th class="table-header-text">Obligatoria</th>
                                    <th class="table-header-text">Colectiva</th>
                                    <th class="table-header-text">Hr. Lectivas</th>
                                    <th class="table-header-text">Precio</th>
                                    <th class="table-header-text">Ratio Max.</th>
                                </tr>
                                <tr class="table-divider-row">
                                    <td colspan="5" class="table-divider"></td>
                                </tr>
                                <tr class="table-row" v-for="(subject, index) in props.obj.subjects" :key="subject.id">
                                    <!-- <td class="table-cell-number">{{ index + 1 }}.</td> -->
                                    <td class="table-cell-text"> {{ subject.name }} </td>
                                    <td class="table-cell-text">
                                        <span v-if="subject.is_mandatory == 1">
                                            <i class="fa-duotone fa-check" style="--fa-primary-color: #0056cf; --fa-secondary-color: #005ad8;"></i>                                    
                                        </span>
                                        <span v-else-if="subject.is_mandatory == 0">
                                            <i class="fa-solid fa-xmark" style="color: #636363;"></i>
                                        </span>
                                        <span v-else>
                                            {{ subject.is_mandatory }}
                                        </span>
                                    </td>                                
                                    <td class="table-cell-text">
                                        <span v-if="subject.is_collective == 1">
                                            <i class="fa-duotone fa-check" style="--fa-primary-color: #2a6cc9; --fa-secondary-color: #2a6cc9;"></i>                                    
                                        </span>
                                        <span v-else-if="subject.is_collective == 0">
                                            <i class="fa-solid fa-xmark" style="color: #636363;"></i>
                                        </span>
                                        <span v-else>
                                            {{ subject.is_collective }}
                                        </span>
                                    </td>                                
                                    <td class="table-cell-text"> {{ subject.school_hours }} </td>
                                    <td class="table-cell-text"> {{ subject.price }} </td>
                                    <td class="table-cell-text"> {{ subject.student_ratio == null ? '-' : subject.student_ratio }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: transparent;
        min-height: 7rem;
        height: auto;
        padding: 0rem 10rem;
        box-shadow: 0px 0px 8px 0px rgba(0, 0, 0, 0.20);
        /* border-bottom: 4px solid #06aa27; */
        cursor: pointer;
    }

.container-fluid{
    position:relative;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

    .target-text {
        color: #2B5DB6;
        font-weight: 600;
        font-size: 1.7rem;
        }

    .target-info {
        display: flex;
        flex-direction: column;
        align-items: center;
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
        font-size: 1.4rem;
        padding-right: 7rem;
        border-radius: 8rem;
        padding-left: 2rem;
    }

    .table-container {
    overflow-x: auto;
}

    .searchbar input:focus {
        box-shadow: none;
    }

    .searchbar .fa-magnifying-glass {
        position: absolute;
        top: .6rem;
        right: 3rem;
        font-size: 1.7rem;
        color: #2B5DB6;
        cursor: pointer;
    }
    .container-header .fa-circle-plus {
        margin-left: 2rem;
        font-size: 4rem;
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
        padding-top: 1rem;
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

    .badge {
        background-color: #E8F4FF;
        color: #117BEC;
        font-size: 0.8rem;
        font-weight: 500;
        padding: .5rem 1rem;
        border-radius: 0.5rem;
        margin: .5rem 0rem;
    }

    .table-header-text {
        font-weight: 600;
    }

    .table-target {
        width: 100%;
        text-align: center;
    }

    .table-header-text {
        padding-bottom: 1rem;
        
    }



    .table-cell-text {
        align-items: center;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    
    .table-row {
        border-top: 1px solid #D3D3D3; /* Color gris */
    }
    
    

.gear-container {
    position: absolute;  /* Hace que se pueda posicionar relativo a su contenedor más cercano con posición relativa */
    right: -2rem;        /* Ajusta según la distancia que desees del borde derecho de la tarjeta */
    margin-top: 1.5rem;
    transform: translateY(-50%);  /* Ajusta el centrado vertical */
}


</style> 