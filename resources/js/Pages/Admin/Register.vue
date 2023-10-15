<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    phone1: '',
    gender: '',
    role_id: '',
});

const submit = () => {
    form.post(route('admin.register'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>

    <Head title="Matricular Usuario" />

    <AuthenticatedLayout>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div>
                <InputLabel for="phone1" value="Phone" />

                <TextInput
                    id="phone1"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone1"
                    required
                    autocomplete="phone1"
                />

                <InputError class="mt-2" :message="form.errors.phone1" />
            </div>

            <div>
                <InputLabel for="gender" value="Gender" />

                <TextInput
                    id="gender"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.gender"
                    required
                    autocomplete="gender"
                />

                <InputError class="mt-2" :message="form.errors.gender" />
            </div>

            <div>
                <InputLabel for="role_id" value="Rol ID" />

                <TextInput
                    id="role_id"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.role_id"
                    required
                    autocomplete="role_id"
                />

                <InputError class="mt-2" :message="form.errors.role_id" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <ButtonGeneric :disabled="form.processing">Save</ButtonGeneric>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
