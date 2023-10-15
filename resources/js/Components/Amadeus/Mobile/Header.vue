<script setup>
import ApplicationLogoWhite from '@/Components/Amadeus/ApplicationLogoWhite.vue';
import Dropdown from '@/Components/Amadeus/AmadeusDropdown.vue';
import DropdownLink from '@/Components/Amadeus/AmadeusDropdownLink.vue';
import { Link } from '@inertiajs/vue3';
import { permissions } from '@/utils/inertiaUtils';

const title = 'Inicio';
</script>

<template>
    <div class="d-flex flex-row justify-content-around navbar bg-primary">
        <div>
            &lt;
        </div>
        <div>
            {{ title }}
        </div>
        <div></div>
    </div>
</template>

<style scoped>

.navbar {
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    height: 6rem;
    color:white;
}
</style>