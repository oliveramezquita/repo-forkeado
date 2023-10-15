<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <GuestLayout>
        <Head title="Verificar correo" />

        <div class="d-flex flex-column justify-content-center">
            
            <div class="mb-4 text-sm">
                Correo electrónico verificado.
            </div>

            <div class="mt-4 d-flex flex-column items-center justify-between">
                <Link
                    :href="route('dashboard')"
                    as="button"
                    class="underline text-sm rounded-md"
                    >Ir a Amadeus</Link
                >
            </div>
        </div>
    </GuestLayout>
</template>
