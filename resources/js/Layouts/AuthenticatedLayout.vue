<script setup>
import HeaderComponent from '@/Components/Amadeus/Header.vue'
import SidebarComponent from '@/Components/Amadeus/Sidebar.vue'
import GridLayout from '@/Components/Custom/GridLayout.vue';

const props = defineProps({
    croute: String,
});

</script>

<template>

    <GridLayout />

    <HeaderComponent />
    <div class="container-fluid main-content-wrapper">
        <div class="row justify-center">
            <SidebarComponent :croute=props.croute />
            <div class="col-12 padding-main-layout py-12">
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
    
</template>


<style>

.main-content-wrapper {
    /* Aquí también */
    height: calc(100vh - 5.2rem); 
    /* Ajusta según la altura real de tu header  */
    margin-top: 5rem; 
    overflow-y: auto;
}

.padding-main-layout{
    width: 69.65vw;
}

</style>