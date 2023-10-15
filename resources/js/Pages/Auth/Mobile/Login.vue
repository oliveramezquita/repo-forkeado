<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import MobileGuestLayout from '@/Layouts/Mobile/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    enrollmentStatus: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <MobileGuestLayout>
        <Head title="Iniciar Sesión" />

        <form @submit.prevent="submit" class="flex flex-col justify-center h-full">

            <div class="mt-6">
				<h3 class="welcome">¡Hola versión móvil!</h3>
			</div>

            <div class="flex flex-col items-center mt-4">
                <InputLabel for="email" value="Correo electrónico" class="form-label" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full form-control"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2 form-text" :message="form.errors.email" />
            </div>

            <div class="flex flex-col items-center mt-4">
                <InputLabel for="password" value="Contraseña" class="form-label" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full form-control"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2 form-text" :message="form.errors.password" />
            </div>

            <div class="flex flex-col items-center mt-4">
                <label class="flex items-center w-3/4 ml-4">
                    <Checkbox name="remember" v-model:checked="form.remember" class="form-check-input" />
                    <span :class="[form.remember ? 'text-gray-600' : 'text-black', 'ml-2 text-sm dark:text-gray-400 form-check-label']">Mantener sesión iniciada</span>
                </label>
            </div>

            <div class="mt-4">
                <Link
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500  restart-account"
                >
                    ¿Has olvidado tu contraseña?
                </Link>
            </div>

            <div class="block items-center mt-3">
                <ButtonGeneric class="btn submit-button w-full" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing">
                    Acceder
                </ButtonGeneric>
            </div>

            <div class="items-center mt-4 w-full">
                <div>
                    <Link
                    role="link"
                    :href="enrollmentStatus ? route('register') : ''"
                    :disabled="!enrollmentStatus"
                    :class="{disabled: !enrollmentStatus}"
                    class="text-sm text-gray-600"
                    >
                        Matriculate
                    </Link>
                </div>
                <span v-if="!enrollmentStatus" class="text-primary">La matriculación está deshabilitada.</span>
                <div v-if="$page.props.flash.success" class="text-success mt-2 text-center">{{ $page.props.flash.success }}</div>
            </div>
        </form>
    </MobileGuestLayout>
</template>

<style scoped>

.welcome {
	color: #3C7FF8;
    font-weight: 800;
    font-size: 2rem;
    margin-bottom: 5vh;

}

.form-control {
    width: 75%;
    height: 4rem;
    border-radius: 2rem;
    border: 1px solid #2b5db6;
    background: #fff;
    font-size: 1.5rem;
    text-align: center;
}

.form-label {
    font-weight: 600;
    font-size: 1.2rem;
    color: #222038;
    text-align: start;
    width: 75%;
    margin-left: 1rem;
}

.form-check-label{
    margin-bottom: 5vh;
}

.form-check-input{
    margin-bottom: 5vh;
}
.submit-button {
	margin-bottom: 8vh;
}

</style>