<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref, watch } from 'vue';

import { permissions } from '@/utils/inertiaUtils';

const page = usePage();

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
const showSuccessMessage = ref(false);

/**
 * An watch is used to the success message to recreate the animation made in degree
 */
watch(() => page.props.flash.success, (newValue) => {
    if (newValue) {
        showSuccessMessage.value = true;
        setTimeout(() => {
            showSuccessMessage.value = false;
        }, 2000);
    }
}, { immediate: true });

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
            <input v-model="form.name" type="text" class="input-text" id="name" placeholder="Ingrese el nombre" required
                autofocus>
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
            <!-- Validations were added to note the checked values -->
            <div class="col-5">
                <div class="form-check form-switch">
                    <input class="form-check-input switch-rotate" type="checkbox" role="switch" id="switch_is_collective"
                        v-model="form.switch_is_collective">
                    <label class="form-check-label" for="switch_is_collective" value="0"
                        :class="[form.switch_is_collective == 0 ? 'activated' : '']">Individual</label>
                    <label class="form-check-label" for="switch_is_collective" value="1"
                        :class="[form.switch_is_collective == 1 ? 'activated' : '']">Grupo</label><br>
                </div>
            </div>
            <div class="col-5 ms-5">
                <div class="form-check form-switch">
                    <input class="form-check-input switch-rotate" type="checkbox" role="switch" id="switch_is_mandatory"
                        v-model="form.switch_is_mandatory">
                    <label class="form-check-label" for="switch_is_mandatory" value="0"
                        :class="[form.switch_is_mandatory == 0 ? 'activated' : '']">Optativa</label><br>
                    <label class="form-check-label" for="switch_is_mandatory" value="1"
                        :class="[form.switch_is_mandatory == 1 ? 'activated' : '']">Obligarotia</label>
                </div>
            </div>
        </div>

        <!-- Added Bootstrap classes for element spacing -->
        <div class="my-3 d-flex flex-row">
            <div class="col-5">
                <label for="student_ratio" class="form-label">Ratio de alumnos</label>
                <input v-model="form.student_ratio" type="number" class="input-text" id="student_ratio" required>
            </div>
            <div class="col-5 ms-5">
                <label for="price" class="form-label">Precio (€)</label>
                <input v-model="form.price" type="number" step=".01" class="input-text" id="price" required>
            </div>
        </div>

        <div class="d-flex flex-column mt-4">
            <ButtonGeneric class="btn create-button w-100 mb-3"
                :class="{ 'success-feedback': showSuccessMessage, 'opacity-25': form.updating || form.processing }"
                :disabled="form.updating || form.processing">

                <template v-if="form.updating || form.processing">
                    <i class="fa-solid fa-compact-disc fa-spin" style="color: #ffffff;"></i>
                </template>

                <template v-else-if="showSuccessMessage">
                    <i class="fa-regular fa-circle-check white-icon"></i>
                </template>

                <template v-else>
                    {{ props.edit === 'false' ? 'Crear' : 'Actualizar' }}
                </template>

            </ButtonGeneric>
            <DangerButton
                v-if="props.edit === 'true' && props.obj.is_active == '1' && permissions.includes('subject.destroy')"
                class="btn w-100" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing" @click="destroy">
                Desactivar
            </DangerButton>
            <SecondaryButton
                v-if="props.edit === 'true' && props.obj.is_active == '0' && permissions.includes('subject.activate')"
                class="btn w-100" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing" @click="activate">
                Reactivar
            </SecondaryButton>
        </div>

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

/**
* Three classes were added to adapt the subject modal to how desired in the Figma design
*/
.switch-rotate {
    transform: rotate(90deg);
    margin-top: 15px;
    width: 2.5em;
}

label.form-check-label {
    color: gray;
}

label.activated {
    color: #3c7ff8 !important;
}

.create-button {
    margin-top: 6rem;
}

.success-feedback {
    background-color: #229e26;
    /* Por ejemplo, verde. Ajusta según tus necesidades. */
    transition: background-color 0.3s ease;
}

.success-feedback:hover {
    background-color: #19af21;
    /* Un tono de verde un poco más oscuro en el hover. Ajusta según tus necesidades. */
}

.submit-button .fa-spinner {
    font-size: 1.2rem;
    color: white;
}

/* Asegurémonos de que la transición también se aplique cuando el botón no esté en su estado de éxito */
.btn.create-button {
    transition: background-color 0.3s ease, color 0.3s ease;
}

.white-icon {
    color: white;
}

@keyframes checkAnimation {
    0% {
        transform: scale(0.5) rotate(-45deg);
        opacity: 0.5;
    }

    100% {
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
}

.white-icon {
    animation: checkAnimation 0.5s forwards;
    color: white;
    /* Para asegurarte de que el ícono sea blanco */
}
</style>
