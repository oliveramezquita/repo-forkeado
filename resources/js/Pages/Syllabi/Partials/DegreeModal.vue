<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref, watch } from 'vue';

const page = usePage();

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
            max_failed_subjects_to_pass: '',
        }),
    },
});

const createRoute = route('degree.store');
const updateRoute = route('degree.update');
const destroyRoute = route('degree.destroy');
const activateRoute = route('degree.activate');
const showSuccessMessage = ref(false);

const form = useForm({
    id: props.obj.id,
    name: props.obj.name,
    max_failed_subjects_to_pass: props.obj.max_failed_subjects_to_pass,
    updating: false,
    destroy: false,
    activate: false,
});

const submit = () => {
    form.update = true; // Añadir esto
    if (props.edit === 'false') {
        form.post(createRoute, {
            onSuccess: () => {
                form.reset();
                form.update = false; // Añadir esto
            },
        });
    } else {
        form.patch(updateRoute, {
            onSuccess: () => {
                form.updating = false; // Añadir esto
            },
        });
    }
};


const destroy = () => {
    form.destroy = true; // Añadir esto
    form.delete(destroyRoute, {
        onSuccess: () => {
            form.destroy = false; // Añadir esto
        },
    });
};

const activate = () => {
    form.activate = true; // Añadir esto
    form.patch(activateRoute, {
        onSuccess: () => {
            form.activate = false; // Añadir esto
        },
    });
};

watch(() => page.props.flash.success, (newValue) => {
    if (newValue) {
        switch (newValue) {
            case 'degree.store':
                // Lógica para cuando un grado es creado
                showSuccessMessage.value = true;
                form.update = false;
                form.destroy = false;
                form.activate = false;
                break;
            case 'degree.update':
                // Lógica para cuando un grado es actualizado
                showSuccessMessage.value = true;
                form.update = true;
                form.destroy = false;
                form.activate = false;
                break;
            case 'degree.destroy':
                // Lógica para cuando un grado es eliminado
                showSuccessMessage.value = true;
                form.update = false;
                form.destroy = true;
                form.activate = false;
                break;
            case 'degree.activate':
                // Lógica para cuando un grado es activado
                showSuccessMessage.value = true;
                form.update = false;
                form.destroy = false;
                form.activate = true;
                break;
        }

        setTimeout(() => {
            showSuccessMessage.value = false;
        }, 2000);
    }
}, { immediate: true });
</script>

<template>
    <form @submit.prevent="submit">

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input v-model="form.name" type="text" class="input-text" id="name" placeholder="Ingresa el nombre" required
                autofocus minlength="4">
        </div>

        <div class="mb-3">
            <label for="max_failed_subjects_to_pass" class="form-label">Máximo de asignaturas suspensas</label>
            <input v-model="form.max_failed_subjects_to_pass" type="numeric" class="input-text"
                id="max_failed_subjects_to_pass" required min="0" max="99">
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
                v-if="props.edit === 'true' && props.obj.is_active == '1' && permissions.includes('degree.destroy')"
                class="btn desactive-button w-100" :class="{ 'opacity-25': form.destroy }" :disabled="form.destroy"
                @click="destroy">
                Desactivar
            </DangerButton>

            <SecondaryButton
                v-if="props.edit === 'true' && props.obj.is_active == '0' && permissions.includes('degree.activate')"
                class="btn submit-button w-100" :class="{ 'opacity-25': form.activate }" :disabled="form.activate"
                @click="activate">
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

.form-label_secondary {
    font-size: 1rem;
    font-weight: 300;
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