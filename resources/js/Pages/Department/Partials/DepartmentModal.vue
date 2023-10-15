<script setup>
import { useForm } from '@inertiajs/vue3';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import { permissions } from '@/utils/inertiaUtils';

const props = defineProps({
    edit: {
        type: String,
        default: "false",
    },
    teachers: Array,
    obj: {
        type: Object,
        default: () => ({
            id: '',
            name: '',
            in_charge: '',
            color: '',
            meeting_day: '',
            meeting_time: '',
        }),
    },
});

const createRoute = route('department.store');
const updateRoute = route('department.update');
const destroyRoute = route('department.destroy');
const activateRoute = route('department.activate');

const filteredTeachers = props.teachers.map(teacher => ({
    id: teacher.id,
    name: teacher.name,
}));

const form = useForm({
    id: props.obj.id,
    name: props.obj.name,
    user_id: props.obj.in_charge ? props.obj.in_charge.id : 0,
    color: props.obj.color,
    meeting_day: props.obj.meeting_day ? props.obj.meeting_day : 1,
    meeting_time: props.obj.meeting_time,
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

</script>

<template>
    <form @submit.prevent="submit">

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input v-model="form.name" type="text" class="input-text" id="name" placeholder="Ingresa el nombre" required autofocus>
        </div>

        <div class="my-3">
            <label for="user_id" class="form-label">Jefe Departamento</label>
            <select v-model="form.user_id" class="input-select" id="user_id" required>
                <option value="0" selected disabled>Selecciona una opción</option>
                <option v-for="teacher in filteredTeachers" :value="teacher.id">{{ teacher.name }}</option>
            </select>
        </div>

        <div>
            <label for="color" class="form-label">Color</label>
            <input v-model="form.color" type="color" class="input-text" id="color">
        </div>

        <div>
            <label for="meeting_day" class="form-label">Día de reunión</label>
            <select name="meeting_day" v-model="form.meeting_day">
                <option value="1">Lunes</option>
                <option value="2">Martes</option>
                <option value="3">Miércoles</option>
                <option value="4">Jueves</option>
                <option value="5">Viernes</option>
                <option value="6">Sábado</option>
                <option value="7">Domingo</option>
            </select>

            <label for="meeting_time" class="form-label">Hora de reunión</label>
            <input v-model="form.meeting_time" type="time" class="input-text" id="meeting_time">
        </div>

        <div class="d-flex flex-column mt-4">
            <ButtonGeneric class="btn submit-button w-100 mb-3" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing">
                {{ props.edit === 'false' ? 'Crear' : 'Actualizar' }}
            </ButtonGeneric>
            <DangerButton v-if="props.edit === 'true' && props.obj.is_active == '1' && permissions.includes('department.destroy')" class="btn submit-button w-100" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing" @click="destroy">
                Desactivar
            </DangerButton>
            <SecondaryButton v-if="props.edit === 'true' && props.obj.is_active == '0' && permissions.includes('department.activate')" class="btn submit-button w-100" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing" @click="activate">
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


.submit-button {
    margin-top: 6rem;
}


</style>