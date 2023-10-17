<script setup>
import { ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import { permissions } from '@/utils/inertiaUtils';

const page = usePage();

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
const showSuccessMessage = ref(false);

let selectedNumber = ref(props.obj.number);

watch(selectedNumber, (newNumber) => {
    if (newNumber >= 0 && newNumber < props.coursesDict.length) {
        form.name = props.coursesDict[newNumber];
        form.number = newNumber.toString();
    }
});

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
                v-if="props.edit === 'true' && props.obj.is_active == '1' && permissions.includes('course.destroy')"
                class="btn w-100" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing" @click="destroy">
                Desactivar
            </DangerButton>
            <SecondaryButton
                v-if="props.edit === 'true' && props.obj.is_active == '0' && permissions.includes('course.activate')"
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
.input-text {
    background-color: #e8e8e8;
    color: grey;
    border-color: #929191;
}

.form-label {
    font-size: 1rem;
    font-weight: 500;
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