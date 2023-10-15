<template>
    <div class="time-slot">
        <div v-for="hour in hours" :key="hour" class="hour">
            {{ hour }}
        </div>
    </div>
</template>
  
<script setup>
   const props = defineProps(['hours']);
</script>
  
<style scoped>
    .time-slot {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        padding-right: 10px;
        border-right: 1px solid #ccc;
    }
  
    .hour {
        height: 60px; /* Ajusta según tus necesidades */
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
</style>
  