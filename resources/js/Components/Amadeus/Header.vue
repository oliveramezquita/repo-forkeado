<script setup>
import ApplicationLogoWhite from '@/Components/Amadeus/ApplicationLogoWhite.vue';
import Dropdown from '@/Components/Amadeus/AmadeusDropdown.vue';
import DropdownLink from '@/Components/Amadeus/AmadeusDropdownLink.vue';
import { Link } from '@inertiajs/vue3';
import { permissions } from '@/utils/inertiaUtils';

// Crea un array de notificaciones 
const notifications = [
    {
        id: 1,
        user: {
            name: 'Dennis',
            surname: 'Nedry',
            photo_url: 'http://localhost:8000/storage/sample_avatar.jpeg',
        },
        action: 'commented',
        over: 'Calificaciones - Lenguaje Musical',
        description: 'Lorem ipsum dolor sit amet, consectetur',
        datetime: '2021/09/01 9:32',
        model_name: 'califications',
    },
    {
        id: 2,
        user: {
            name: 'Pablo',
            surname: 'Jiménez',
            photo_url: 'http://localhost:8000/storage/sample_avatar.jpeg',
        },
        action: 'shared',
        over: 'Concierto de Arte Musical Contemporáneo',
        datetime: '2021/09/01 9:42',
        model_name: 'events',
    },
    {
        id: 3,
        user: {
            name: 'Dennis',
            surname: 'Nedry',
            photo_url: 'http://localhost:8000/storage/sample_avatar.jpeg',
        },
        action: 'commented',
        over: 'Calificaciones - Lenguaje Musical',
        description: 'Lorem ipsum dolor sit amet, consectetur',
        datetime: '2021/09/01 9:42',
        model_name: 'califications',
    },
    {
        id: 4,
        user: {
            name: 'Pablo',
            surname: 'Jiménez',
            photo_url: 'http://localhost:8000/storage/sample_avatar.jpeg',
        },
        action: 'shared',
        over: 'Concierto de Arte Musical Contemporáneo',
        datetime: '2021/09/01 9:42',
        model_name: 'events',
    },
];

</script>

<template>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid justify-content-xxl-between">
            <div>
                <Link href="/">
                    <ApplicationLogoWhite class="logo"/>
                </Link>
            </div>
            <div class="nav-items">
                <Dropdown align="right" width="100">
                    <template #trigger>
                        <span class="inline-flex nav-user">
                            <button
                                type="button"
                                class="text-light inline-flex items-center leading-4 hover:text-gray-700 focus:outline-none"
                            >
                                <!-- Icono del usuario -->
                                <i class="fa-light fa-circle-user icon-size me-2"></i>
                                <!-- Nombre del usuario -->
                                {{ $page.props.auth.user.name }}
                                
                                <!-- Icono de flecha hacia abajo -->
                                <svg
                                    class="ml-2 -mr-0.5 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('profile.edit')"> Perfil </DropdownLink>
                        <DropdownLink v-if="permissions.includes('school.settings.edit')" :href="route('school.settings.edit')"> Centro </DropdownLink>
                    </template>
                </Dropdown>

                <Link
                    :href="route('messaging.show')"
                    as="button">
                    <i class="fa-light fa-message text-light icon-size cursor-pointer"></i>
                </Link>

                <!-- Notificaciones -->
                <i class="fa-light fa-bell text-light icon-size cursor-pointer"></i>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button">
                    <i class="fa-light fa-arrow-right-from-bracket text-light icon-size"></i>
                </Link>
            </div>
        </div>
    </nav>
</template>

<style lang="scss" scoped>

.main-container {
  margin-top: 3vh; /* Ajusta esta altura según el tamaño de tu menú superior */
 
}

.logo {
    width: 12rem;
    height: 2rem;
}

.icon-size {
    font-size: 1.5rem;
}

.navbar-expand-lg {
    // padding: 2vh 4vw 2vh 1.5vw;
    padding: 1.4rem 3.375rem 1.4rem 3rem;
}

.nav-items {
    display: flex;
    flex-direction: row;
    // padding: 0rem 6.5rem;
    justify-content: flex-end;
    align-items: center;
    gap: 2rem;
}
/* Ensuring vertical alignment of all elements in nav-items */
.nav-items > * {
    display: flex;
    flex-direction: row;
    align-items: center;
}

.nav-user {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.3rem;
    font-weight: 400;
}

.fa-chevron-down {
    font-size: 1.1rem;
}

// Aquí añadimos el código sugerido para hacer el header fijo
.navbar {
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1100;
    height: 5rem;
}
</style>