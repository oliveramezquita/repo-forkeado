<script setup>
import { useForm } from '@inertiajs/vue3';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

import { permissions } from '@/utils/inertiaUtils';

const props = defineProps({
    departments: {
       type: Array,
       default: () => [],
    },
    edit: {
        type: String,
        default: "false",
    },
    obj: {
        type: Object,
        default: () => ({
            is_mandatory: 1,
            is_collective: 1,
        }),
    },
});

const createRoute = route('subject.store');
const updateRoute = route('subject.update');
const destroyRoute = route('subject.destroy');
const activateRoute = route('subject.activate');

const switch_is_mandatory = ref(props.obj.is_mandatory === 1 ?? true);
const switch_is_collective = ref(props.obj.is_collective === 1 ?? true);

const form = useForm({
    id: props.obj.id || '',
    name: props.obj.name || '',
    department_id: props.obj.department_id || '',
    school_hours: props.obj.school_hours || '',
    switch_is_mandatory: switch_is_mandatory,
    switch_is_collective: switch_is_collective,
    price: props.obj.price || '',
    student_ratio: props.obj.student_ratio || '',
});

const submit = () => {
    if (props.edit === 'false') {
        form.post(createRoute, {
            onSuccess: () => {
                form.reset();
            },
        });
    } else {
        form.patch(updateRoute);
    }
};

const destroy = () => {
    form.delete(destroyRoute);
};

const activate = () => {
    form.patch(activateRoute);
};

const filteredDepartments = props.departments.map(department => ({
    id: department.id,
    name: department.name,
}));

</script>

<template>
    <form @submit.prevent="submit">

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input v-model="form.name" type="text" class="input-text" id="name" placeholder="Ingrese el nombre" required autofocus>
        </div>

        <div class="my-3 row" v-if="props.edit === 'false'">
            <div class="col-9">
                <label for="department_id" class="form-label">Departamento</label>
                <select v-model="form.department_id" class="input-text" id="department_id">
                    <option value="" selected>Seleccione</option>
                    <option v-for="department in filteredDepartments" :value="department.id">{{ department.name }}</option>
                </select>
            </div>
            <div class="col-3">
                <label for="school_hours" class="form-label">Horas</label>
                <input v-model="form.school_hours" type="number" class="input-text" step=".01" id="school_hours" required>
            </div>
        </div>

        <label class="form-label">Opciones</label>
        <div class="my-3 d-flex flex-row">
            <div>
                <div class="form-check form-switch me-5">
                    <input class="form-check-input rotate" type="checkbox" role="switch" id="switch_is_mandatory" v-model="form.switch_is_mandatory">
                    <label class="form-check-label" for="switch_is_mandatory" value="0">Optativa</label><br>
                    <label class="form-check-label" for="switch_is_mandatory" value="1">Obligatoria</label>
                </div>
            </div>
            <div>
                <div class="form-check form-switch me-5">
                    <input class="form-check-input rotate" type="checkbox" role="switch" id="switch_is_collective" v-model="form.switch_is_collective">
                    <label class="form-check-label" for="switch_is_collective" value="0">Individual</label>
                    <label class="form-check-label" for="switch_is_collective" value="1">Colectiva</label><br>
                </div>
            </div>
        </div>
        
        <div class="my-3 d-flex flex-row">
                <div>
                    <label for="student_ratio" class="form-label">Ratio de alumnos</label>
                    <input v-model="form.student_ratio" type="number" class="form-control" id="student_ratio" required>
                </div>
                <div>
                    <label for="price" class="form-label">Precio (€)</label>
                    <input v-model="form.price" type="number" step=".01" class="form-control" id="price" required>
                </div>
            </div>

        <div class="d-flex flex-column mt-4">
            <ButtonGeneric class="btn submit-button w-100 mb-3" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing">
                {{ props.edit === 'false' ? 'Crear' : 'Actualizar' }}
            </ButtonGeneric>
            <DangerButton v-if="props.edit === 'true' && props.obj.is_active == '1' && permissions.includes('subject.destroy')" class="btn submit-button w-100" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing" @click="destroy">
                Desactivar
            </DangerButton>
            <SecondaryButton v-if="props.edit === 'true' && props.obj.is_active == '0' && permissions.includes('subject.activate')" class="btn submit-button w-100" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing" @click="activate">
                Reactivar
            </SecondaryButton>
        </div>
        
        <div v-if="$page.props.flash.success" class="text-success mt-2 text-center">{{ $page.props.flash.success }}</div>
        <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0" class="text-danger mt-2 text-center">
            <ul>
                <li v-for="(error, field) in $page.props.errors">{{ error }}</li>
            </ul>
        </div>
    </form>

</template>

<style scoped>

.form-label {
    font-size: 1rem;
    font-weight: 500;
}

</style>