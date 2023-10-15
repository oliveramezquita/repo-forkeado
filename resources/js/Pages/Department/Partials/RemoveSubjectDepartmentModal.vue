<script setup>
import { useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
  id: Number,
  subject_id: Number,
});

const destroyeRoute = route('department.subject.destroy');

const form = useForm({
  id: props.id,
  subject_id: props.subject_id,
});


const submit = () => {
  form.delete(destroyeRoute, {
    onSuccess: () => {
    },
  });
};
</script>

<template>
    <form @submit.prevent="submit">
  
      <div class="d-flex flex-column mt-4">
        <DangerButton class="btn submit-button w-100 mb-3" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing">
          Eliminar asignatura
        </DangerButton>
      </div>
  
      <div v-if="$page.props.flash.success" class="text-success mt-2 text-center">{{ $page.props.flash.success }}</div>
      <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0" class="text-danger mt-2 text-center">
        <ul>
          <li v-for="(error, field) in $page.props.errors">{{ error }}</li>
        </ul>
      </div>
    </form>
  </template>

<style scoped>

.form-select {
    height: 100%;
}

</style>