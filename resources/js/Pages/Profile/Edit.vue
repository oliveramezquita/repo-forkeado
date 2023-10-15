<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

const customroute = 'profile.edit';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
        type: Array,
        default: () => [],
    },
    guardian: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout :croute="customroute">

        <div class="mx-auto">
            Perfil

            <div id="personal-data">
                <img :src=user.photo_url class="rounded-full h-20 w-20 object-cover">
                <div>
                    <div class="p-5">
                        {{ guardian.name }} {{ guardian.surname }} {{ guardian.email }}
                    </div>
                    <div class="p-5"> 
                        {{ user.name }} {{ user.surname }} {{ user.email }}
                    </div>
                </div>
            </div>

        </div>

        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>
            </div>
        </div> -->
    </AuthenticatedLayout>
</template>
