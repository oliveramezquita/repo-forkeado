<script setup>
import { ref, watch } from 'vue';
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
    obj: {
        type: Object,
        default: () => ({
            id: '',
            name: '',
            number: '',
        }),
    },
    coursesDict: {
        type: Array,
        default: () => []
    },
});

const createRoute = route('course.store');
const updateRoute = route('course.update');
const destroyRoute = route('course.destroy');
const activateRoute = route('course.activate');

let selectedNumber = ref(props.obj.number);

watch(selectedNumber, (newNumber) => {
    if (newNumber >= 0 && newNumber < props.coursesDict.length) {
        form.name = props.coursesDict[newNumber];
        form.number = newNumber.toString();
    }
});

const form = useForm({
    id: props.obj.id,
    name: props.obj.name,
    number: props.obj.number,
});

const submit = () => {
    if (props.edit === 'false') {
        form.post(createRoute, {
            onSuccess: () => {
                form.reset();
                selectedNumber = ''; 
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
        
        <div class="my-3">
            <label for="number" class="form-label">Número</label>
            <select v-model="selectedNumber" class="input-select" id="number" required>
                <option value="" disabled>Selecciona una opción</option>
                <option v-for="(course, index) in coursesDict" :value="index" :key="index">
                    {{ index }}
                </option>
            </select>
        </div>

        <div class="my-3">
            <label for="name" class="form-label">Nombre</label>
            <input v-model="form.name" type="text" class="input-text" id="name" placeholder="" required disabled>
        </div>

        <div class="d-flex flex-column mt-4">
            <ButtonGeneric class="btn submit-button w-100 mb-3" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing">
                {{ props.edit === 'false' ? 'Crear' : 'Actualizar' }}
            </ButtonGeneric>
            <DangerButton v-if="props.edit === 'true' && props.obj.is_active == '1' && permissions.includes('course.destroy')" class="btn submit-button w-100" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing" @click="destroy">
                Desactivar
            </DangerButton>
            <SecondaryButton v-if="props.edit === 'true' && props.obj.is_active == '0' && permissions.includes('course.activate')" class="btn submit-button w-100" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing" @click="activate">
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
.input-text{
    background-color: #e8e8e8;
    color: grey;
    border-color: #929191;
}

.form-label {
    font-size: 1rem;
    font-weight: 500;
}


.submit-button {
    margin-top: 6rem;
}



</style>