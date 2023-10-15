<template>
    <div class="grid-overlay" v-if="gridVisible">
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
      <div class="column"></div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const gridVisible = ref(false);

const onResize = (element) => {
console.log("Element resized:", element);
}


onMounted(() => {
const handleKeydown = (e) => {
    if (e.ctrlKey && e.key === 'g') {
    gridVisible.value = !gridVisible.value;
    }
};
window.addEventListener('keydown', handleKeydown);

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown);
});
});
</script>

<style>
.grid-overlay {
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: calc(12 * 4.1vw + 11 * 1.75vw); 
    height: 100%;
    pointer-events: none;
    z-index: 9999;
}

.grid-overlay .column {
    float: left;
    width: 4.1vw; 
    height: 100%;
    background-color: rgba(255, 0, 0, 0.1);
    box-sizing: border-box;
}

/* Añadir el gutter */
.grid-overlay .column + .column {
    margin-left: 1.75vw;
}
</style>
