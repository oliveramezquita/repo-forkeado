<script setup>
import HeaderComponent from '@/Components/Amadeus/Mobile/Header.vue'
import FooterComponent from '@/Components/Amadeus/Mobile/Footer.vue'
import FooterComponentSample from '@/Components/Amadeus/Mobile/FooterSample.vue'
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
            <div class="col-12 padding-main-layout py-12">
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
    <FooterComponentSample />
    
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