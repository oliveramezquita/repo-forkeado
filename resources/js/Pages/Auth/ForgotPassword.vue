<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Restablecer Contraseña" />

        <form @submit.prevent="submit" class="flex flex-col justify-center h-full">

            <div class="mt-6">
                <h3 class="welcome">Recuperar Contraseña</h3>
            </div>

            <div class="mb-4 text-sm text-gray-900 ">
                ¿Has olvidado tu contraseña? No hay problema. Solamente añade tu email y te enviaremos un enlace para establecer una nueva contraseña.
            </div>

            <div class="flex flex-col items-center mt-4">
                <InputLabel for="email" value="Email" class="form-label" />

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

            <div class="block items-center mt-3">
                <ButtonGeneric class="btn submit-button w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Restablecer
                </ButtonGeneric>
            </div>

            <div class="items-center mt-4 w-full">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Volver al inicio de sesión
                </Link>
            </div>
        </form>

    </GuestLayout>
</template>

<style scoped> 
.welcome {
    color: #3C7FF8;
    font-weight: 800;
    font-size: 2rem;
    margin-bottom: 5vh;

}

.form-label {
    font-weight: 600;
    font-size: 1.2rem;
    color: #222038;
    text-align: start;
    width: 75%;
    margin-left: 1rem;
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

</style>
  