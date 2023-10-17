// Nombre - Oliver Amézquita Morales
// Me costo entrar en ritmo con Vue.js pero bastaron unas pocas horas para ponerme en ritmo
// Creo que lo más desafiante de la prueba técnica fue realizar la comunicación entre componentes
// Las tres funcionalidades fueron realizadas además de algunas otras correcciones en funcionalidad y estética de la aplicación 

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Title from '@/Components/Amadeus/Title.vue';
import Modal from '@/Components/Amadeus/Modal.vue';
import { Head, usePage } from '@inertiajs/vue3';
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

const page = usePage();

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
/**
 * The following elements are created:
 * elementType: Defines the type of element (course, degree, specialty, subject, ...)
 * elementTitle: Defines the title of the element (Curso, Grado, Especialidad, Asignatura, ...)
 * selectedObj: Selected object to modify
 * selectedDict: Selected array or list object to modify
 */
const elementType = ref('');
const elementTitle = ref('');
const selectedObj = ref(null);
const selectedDict = ref(null);

/**
 * A handleUpdateItem is a function that will be emit from the components
 */
const handleUpdateObj = (element, title, obj, dict) => {
    elementType.value = element;
    elementTitle.value = title;
    selectedObj.value = obj;
    selectedDict.value = dict;

    /**
     * Every time the generic modal is called for modifications, 
     * the success props as well as the error props are set to null
     */
    page.props.flash.success = null;
    page.props.errors = null;
}

/**
 * When you change elements in the modal to create objects, 
 * the success and error props are assigned null
 */
const setPageProps = () => {
    page.props.flash.success = null;
    page.props.errors = null;
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
                        <!-- Emit updateObj is associated with local function handleUpdateObj -->
                        <DegreeElementTarget :obj="degree" @updateObj="handleUpdateObj" />
                    </div>
                </div>

                <!-- Mostrando Cursos -->
                <div class="custom-flex">
                    <Title title="Cursos" />
                    <div v-for="course in orderedCourses" :key="course.id">
                        <!-- Emit updateObj is associated with local function handleUpdateObj -->
                        <CourseElementTarget :obj="course" :coursesDict="coursesDict" @updateObj="handleUpdateObj" />
                    </div>
                </div>


            </div>

            <!-- Fila 2 -->
            <div class="d-flex flex-row justify-around gap-5">

                <!-- Mostrando Especialidades -->
                <div class="custom-flex">
                    <Title title="Especialidades" />
                    <div v-for="speciality in orderedSpecialities" :key="speciality.id">
                        <!-- Emit updateObj is associated with local function handleUpdateObj -->
                        <SpecialityElementTarget :obj="speciality" :departments="departments"
                            @updateObj="handleUpdateObj" />
                    </div>
                </div>

                <!-- Mostrando Asignaturas -->
                <div class="custom-flex">
                    <Title title="Asignaturas" />
                    <div v-for="subject in orderedSubjects" :key="subject.id">
                        <!-- Emit updateObj is associated with local function handleUpdateObj -->
                        <SubjectElementTarget :obj="subject" :departments="departments" @updateObj="handleUpdateObj" />
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
                    <select class="input-select" id="typeItem" v-model="selectedType" @change="setPageProps">
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
        <!-- A single modal is created at the element level to modify the different objects -->
        <Modal id="updateItemModal">
            <template #modal-header>
                Modificar {{ elementTitle }}
            </template>
            <template #modal-body>
                <!-- Conditions are used to manage the content of the modal according to the element -->
                <div v-if="elementType === 'degree'">
                    <DegreeModal v-if="selectedObj" :key='elementType + selectedObj.id' edit=true :obj="selectedObj" />
                </div>
                <div v-if="elementType === 'course'">
                    <CourseModal v-if="selectedObj" :key='elementType + selectedObj.id' edit=true :obj="selectedObj"
                        :coursesDict="selectedDict" />
                </div>
                <div v-if="elementType === 'speciality'">
                    <SpecialityModal v-if="selectedObj" :key='elementType + selectedObj.id' edit=true :obj="selectedObj"
                        :departments="selectedDict" />
                </div>
                <div v-if="elementType === 'subject'">
                    <SubjectModal v-if="selectedObj" :key='elementType + selectedObj.id' edit=true :obj="selectedObj"
                        :departments="selectedDict" />
                </div>
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