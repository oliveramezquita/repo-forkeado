<template>
    <div v-if="show" class="dialog">
        <div class="d-flex flex-column justify-content-center">
            <div>
                Nombre del evento: <input v-model="eventName" type="text" />
            </div>
            <div>
                Hora de comienzo: <input v-model="startTime" type="time" />
            </div>
            <div>
                Hora de fin: <input v-model="endTime" type="time" />
            </div>
            <div>
                <button @click="saveEvent" type="button">Guardar</button>
            </div>
        </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits, watch } from 'vue';
  
  const props = defineProps(['show', 'startTimeEvent']);
  const emit = defineEmits(['save']);
  
  const eventName = ref('');
  const endTime = ref('');
  const startTime = ref('');
  
  // Calcula la hora de fin por defecto basándote en startTime
  const calculateDefaultEndTime = (startTime) => {
    let [hour, minute] = startTime.split(':').map(Number);
    hour = (hour + 1) % 24; // Añade 1 hora
    return `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
  };

  watch(
    () => props.startTimeEvent, 
    (newVal) => {
        if (newVal) {
            startTime.value = newVal;
            endTime.value = calculateDefaultEndTime(newVal);
        }
    },
    { immediate: true } // Esto asegura que se ejecute el watcher inmediatamente cuando se crea el componente, además de cuando cambia el valor observado.
    );

  const saveEvent = () => {
    if (eventName.value === '' || startTime.value === '' || endTime.value === '') {
      return;
    }
    emit('save', { name: eventName.value, start: startTime.value, end: endTime.value });
  };
  </script>
  
  <style scoped>
  .dialog {
    /* Estilos para tu diálogo */
    position: fixed;
    top: 50%;
    left: 80%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border: 1px solid #ccc;
    z-index: 999 !important;
  }
  </style>
  