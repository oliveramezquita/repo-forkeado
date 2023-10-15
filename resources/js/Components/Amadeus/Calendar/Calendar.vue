<template>
  <div class="calendar">
    <div class="header">
      <div class="time-slot-header"></div>
      <div v-for="day in props.days" :key="day" class="day-header">{{ day }}</div>
    </div>
    <div class="content">
      <TimeSlot :hours="props.hours" />
      <Day v-for="day in props.days" :key="day" :day="day" :events="props.events[day]" :hours="props.hours" @openDialog="openDialog" />
    </div>
    <Dialog :show="showDialog" :startTimeEvent="selectedStartTime" @save="handleSave" />
  </div>
</template>

<script setup>
import Dialog from './Dialog.vue';
import Day from './Day.vue';
import TimeSlot from './TimeSlot.vue';
import { ref } from 'vue';

const showDialog = ref(false);
const selectedStartTime = ref('');
const selectedDay = ref('');

const props = defineProps(['events', 'days', 'hours']);

const openDialog = (hour, day) => {
  selectedStartTime.value = hour;
  selectedDay.value = day;
  showDialog.value = true;
};

const handleSave = ({ name, start, end }) => {
  showDialog.value = false;
  const event = { name, start, end };
  props.events[selectedDay.value].push(event);
};
</script>

<style scoped>
.calendar .header {
  display: flex;
}

.calendar .content {
  display: flex;
  flex: 1;
}

.day-header, .time-slot-header {
  flex: 1;
  text-align: center;
  padding: 10px;
  background-color: #f9f9f9;
  border-bottom: 1px solid #ccc;
}

</style>