<template>
  <div class="event">
    <div class="h-100 d-flex flex-column justify-content-evenly align-items-center">
        <div class="event-name">{{ event.name }}</div>
        <div class="event-time">
          <div> {{ event.start }} </div>
          <div> - </div>
          <div> {{ event.end }} </div>
        </div>
    </div>
    <div class="top-right" @click="emit('deleteEvent', event)"><i class="fa-solid fa-trash"></i></div>
  </div>
</template>
  
<script setup>
  const props = defineProps(['event']);
    const emit = defineEmits(['deleteEvent']);
</script>
  
<style scoped>
.event {
  width: 100%;
  height: 100%;
  box-sizing: border-box;
  background-color: #e9ecef;
  border-bottom: 2px solid #007bff;
}

.event-name {
  font-weight: bold;
}

.event-time {
  display: flex;
  flex-direction: column;
  color: #6c757d;
}

.top-right {
  position: absolute;
  top: 0;
  right: 0;
  padding: 5px;
  cursor: pointer;
}
</style>
