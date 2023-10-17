<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Title from '@/Components/Amadeus/Title.vue';
import Modal from '@/Components/Amadeus/Modal.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

import { permissions } from '@/utils/inertiaUtils';

import DegreeElementTarget from '@/Pages/Syllabi/Partials/DegreeElementTarget.vue';
import CourseElementTarget from '@/Pages/Syllabi/Partials/CourseElementTarget.vue';
import SpecialityElementTarget from '@/Pages/Syllabi/Partials/SpecialityElementTarget.vue';
import SubjectElementTarget from '@/Pages/Syllabi/Partials/SubjectElementTarget.vue';

import DegreeModal from '@/Pages/Syllabi/Partials/DegreeModal.vue';
import CourseModal from '@/Pages/Syllabi/Partials/CourseModal.vue';
import SpecialityModal from '@/Pages/Syllabi/Partials/SpecialityModal.vue';
import SubjectModal from '@/Pages/Syllabi/Partials/SubjectModal.vue';

const orderList = (list) => {
    return list.slice().sort((a, b) => {
        if (a.is_active && !b.is_active) return -1;
        if (!a.is_active && b.is_active) return 1;

        const nameA = a.name.toUpperCase();
        const nameB = b.name.toUpperCase();

        if (nameA < nameB) return -1;
        if (nameA > nameB) return 1;
        return 0;
    });
};

const orderedSubjects = computed(() => orderList(props.subjects));
const orderedDegrees = computed(() => orderList(props.degrees));
const orderedCourses = computed(() => orderList(props.courses));
const orderedSpecialities = computed(() => orderList(props.specialities));

const props = defineProps({
    courses: Array,
    coursesDict: Array,
    degrees: Array,
    subjects: Array,
    specialities: Array,
    departments: Array,
    teachers: Array,
    customroute: String,
});

const selectedType = ref('0');
const elementType = ref('');
const elementTitle = ref('');
const selectedObj = ref(null);
const selectedDict = ref([]);

const handleUpdateItem = (element, title, obj, dict) => {
    elementType.value = element;
    elementTitle.value = title;
    selectedObj.value = obj;
    selectedDict.value = dict;
}
</script>

<template>
    <Head title="Elementos" />

    <AuthenticatedLayout :croute="customroute">

        <div class="d-flex flex-col justify-start">
            <div class="d-flex flex-row justify-around gap-5">
                <!-- Fila 1 -->

                <!-- Mostrando Grados -->
                <div class="custom-flex">
                    <Title title="Grados" />
                    <div v-for="degree in orderedDegrees" :key="degree.id">
                        <DegreeElementTarget :obj="degree" />
                    </div>
                </div>

                <!-- Mostrando Cursos -->
                <div class="custom-flex">
                    <Title title="Cursos" />
                    <div v-for="course in orderedCourses" :key="course.id">
                        <CourseElementTarget :obj="course" :coursesDict="coursesDict" @updateItem="handleUpdateItem" />
                    </div>
                </div>


            </div>

            <!-- Fila 2 -->
            <div class="d-flex flex-row justify-around gap-5">

                <!-- Mostrando Especialidades -->
                <div class="custom-flex">
                    <Title title="Especialidades" />
                    <div v-for="speciality in orderedSpecialities" :key="speciality.id">
                        <SpecialityElementTarget :obj="speciality" :departments="departments" />
                    </div>
                </div>

                <!-- Mostrando Asignaturas -->
                <div class="custom-flex">
                    <Title title="Asignaturas" />
                    <div v-for="subject in orderedSubjects" :key="subject.id">
                        <SubjectElementTarget :obj="subject" :departments="departments" />
                    </div>
                </div>


            </div>
        </div>

        <!-- Button trigger modal -->
        <div v-if="permissions.includes('degree.store') ||
            permissions.includes('course.store') ||
            permissions.includes('speciality.store') ||
            permissions.includes('subject.store')">
            <a type="button" class="modal-btn" data-bs-toggle="modal" data-bs-target="#addItemModal">
                <i class="fa-solid fa-circle-plus"></i>
            </a>
        </div>

        <Modal id="addItemModal">
            <template #modal-header>
                Crear ítem
            </template>

            <template #modal-body>
                <div class="mb-3">
                    <label for="typeItem" class="button-label"></label>
                    <select class="input-select" id="typeItem" v-model="selectedType">
                        <option value="0" selected disabled>Seleccione un tipo</option>
                        <option value="1" v-if="permissions.includes('degree.store')">Grados</option>
                        <option value="2" v-if="permissions.includes('course.store')">Curso</option>Curso
                        <option value="3" v-if="permissions.includes('speciality.store')">Especialidad</option>
                        <option value="4" v-if="permissions.includes('subject.store')">Asignatura</option>
                    </select>
                </div>

                <div v-if="selectedType === '1'">
                    <DegreeModal />
                </div>

                <div v-if="selectedType === '2'">
                    <CourseModal :coursesDict="coursesDict" />
                </div>

                <div v-if="selectedType === '3'">
                    <SpecialityModal :departments="departments" />
                </div>

                <div v-if="selectedType === '4'">
                    <SubjectModal :departments="departments" />
                </div>
            </template>
        </Modal>
        <Modal id="updateItemModal">
            <template #modal-header>
                Modificar {{ elementTitle }}
            </template>
            <template #modal-body>
                <CourseModal v-if="selectedObj" :key='elementType + selectedObj.id' edit=true :obj="selectedObj"
                    :coursesDict="selectedDict" />
            </template>
        </Modal>

    </AuthenticatedLayout>
</template>

<style scoped>
.modal-btn {
    border-radius: 100%;
    bottom: 2rem;
    height: 4rem;
    position: fixed;
    right: 5rem;
    width: 4rem;
}

.fa-circle-plus {
    width: 100%;
    height: 100%;
    color: #3C7FF8;
    font-size: 4rem;
}

.custom-flex {
    flex: 1 1 0px;
}

.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2B5DB6;
}
</style>