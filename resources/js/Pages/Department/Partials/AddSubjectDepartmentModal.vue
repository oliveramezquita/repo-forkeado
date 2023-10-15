<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';

const props = defineProps({
  id: Number,
  subjects: Array,
});

const createRoute = route('department.subject.store');

const form = useForm({
  id: props.id,
  subject_ids: [],
});

const availableSubjects = ref(props.subjects);

const submit = () => {
  form.post(createRoute, {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
    <form @submit.prevent="submit">
      <div class="d-flex flex-column mt-4">
        <label for="subject_ids" class="form-label">Asignaturas disponibles</label>
        <select v-model="form.subject_ids" class="form-select" id="subject_ids" name="subject_ids" multiple>
          <option v-for="subject in availableSubjects" :key="subject.id" :value="subject.id">{{ subject.name }}</option>
        </select>
      </div>
  
      <div class="d-flex flex-column mt-4">
        <ButtonGeneric class="btn submit-button w-100 mb-3" :class="{ 'opacity-25,': form.processing }" :disabled="form.processing">
          Crear
        </ButtonGeneric>
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