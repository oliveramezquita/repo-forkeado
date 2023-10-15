<template>
    <div class="day">
        <div 
            v-for="hour in hours" 
            :key="hour" 
            class="hour-block"
            :class="{ 'highlight': highlightedHour === hour }" 
            @mouseover="setHighlightedHour(hour)"
            @mouseleave="setHighlightedHour(null)"
        >
          <div class="hour-container">
              <button @click="emit('openDialog', hour, props.day)" type="button">+</button>
          </div>
        </div>
        <div v-for="event in events" :key="event.name" class="event-container" :style="{ top: calculateTop(event.start) + 'px', height: calculateHeight(event.start, event.end) + 'px' }">
            <Event :event="event" @deleteEvent="deleteEvent"/>
        </div>
    </div>
</template>
  
  
<script setup>
    import { ref } from 'vue';
    import Event from './Event.vue';
  
    const props = defineProps(['day', 'events', 'hours']);
    const emit = defineEmits(['openDialog']);
  
    const highlightedHour = ref(null);
    const setHighlightedHour = (hour) => {
        highlightedHour.value = hour;
    };

    const deleteEvent = (event) => {
        const index = props.events.findIndex((e) => e.name === event.name && e.start === event.start && e.end === event.end);
        props.events.splice(index, 1);
    };

    const calculateTop = (start) => {
      const [startHour, startMinute] = start.split(':').map(Number);
      const firstHour = parseInt(props.hours[0]);
      return ((startHour - firstHour) * 60 + startMinute) * (60 / 15); // 60px por hora, dividido en 4 bloques de 15 minutos
    };

    const calculateHeight = (start, end) => {
      const [startHour, startMinute] = start.split(':').map(Number);
      const [endHour, endMinute] = end.split(':').map(Number);
      return ((endHour - startHour) * 60 + (endMinute - startMinute)) * (60 / 15); // 60px por hora, dividido en 4 bloques de 15 minutos
    };
</script>

<style scoped>
.day {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: stretch;
  width: 100%;
  border-right: 1px solid #ccc;
}

.hour, .hour-block {
  height: 60px;
  width: 100%;
  border-bottom: 1px solid #ccc;
}

.hour-container {
  position: relative;
  width: 100%;
  height: 100%;
  z-index: 1;
}

.event-container {
  position: absolute;
  width: 100%;
  z-index: 2;
}

.highlight {
    border: 2px solid #007bff;
    border-radius: 12px;
}

button {
  width: 100%;
  height: 100%;
  font-size: large;
  color: #007bff;
  border: none;
  padding: 5px 5px;
  cursor: pointer;
  opacity: 0; /* Oculta el botón por defecto */
}

.hour-container:hover button {
  opacity: 1; /* Muestra el botón cuando se pasa el cursor sobre el bloque horario */
}

</style>