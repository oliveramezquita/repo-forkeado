<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, reactive, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Amadeus/Modal.vue';

import { permissions } from '@/utils/inertiaUtils';

import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import ButtonOutline from '@/Components/ButtonOutline.vue';
import ButtonDanger from '@/Components/ButtonDanger.vue';

import RemoveSyllabiModal from '@/Pages/Syllabi/Partials/RemoveSyllabiModal.vue';

const searchQuery = ref('');

const filteredDegrees = computed(() => {
    if (!searchQuery.value) return props.degrees; // Si searchQuery está vacío, retorna todos los grados

    return props.degrees.filter(degree =>
        degree.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const isSelectedDegree = (degree) => {
    return selectedDegree && selectedDegree.id === degree.id;
};

const filteredCourses = computed(() => {
    if (!searchQuery.value) return props.courses; // Si searchQuery está vacío, retorna todos los cursos

    return props.courses.filter(course =>
        course.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const isSelectedCourse = (course) => {
    return selectedCourse && selectedCourse.id === course.id;
};


const filteredSpecialities = computed(() => {
    if (!searchQuery.value) return props.specialities; // Si searchQuery está vacío, retorna todas las especialidades

    return props.specialities.filter(speciality =>
        speciality.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const isSelectedSpeciality = (speciality) => {
    return selectedSpecialities_id.includes(speciality.id);
};


const filteredSubjects = computed(() => {
    if (!searchQuery.value) return props.subjects; // Si searchQuery está vacío, retorna todas las asignaturas

    return props.subjects.filter(subject =>
        subject.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});





const toggleFields = (specialityId, subjectId) => {
    const speciality = selectedSpecialities_data[specialityId];
    if (!speciality) {
        console.log('No speciality found with id:', specialityId);
        return;
    }

    const subject = speciality.subjects.find(subj => subj.id === subjectId);
    if (!subject) {
        console.log('No subject found with id:', subjectId);
        return;
    }

    subject.remove = !subject.remove; // Alterna el valor de remove entre true y false
    console.log(selectedSpecialities_data);
};


const props = defineProps({
    customroute: String,
    degrees: Object,
    courses: Object,
    specialities: Object,
    subjects: Object,
    syllabi: Object,
});

// Route to the controller
const updateRoute = route('syllabi.update');

// By default we start on step 5
const currentStep = ref(5);

// Logic for the degree selector
let selectedDegree = props.syllabi.degree;
const activateDegree = (event, degree) => {
    const degreeSelector = document.getElementById('degree-selector');

    degreeSelector.querySelectorAll('.selected').forEach((element) => {
        element.classList.remove('selected');
    });

    event.currentTarget.classList.add('selected');

    selectedDegree = degree;
};

// Logic for the course selector
let selectedCourse = props.syllabi.course;
const activateCourse = (event, course) => {
    const courseSelector = document.getElementById('course-selector');

    courseSelector.querySelectorAll('.selected').forEach((element) => {
        element.classList.remove('selected');
    });

    event.currentTarget.classList.add('selected');

    selectedCourse = course;
};

// Logic for the speciality selector
let selectedSpecialities = props.syllabi.specialities;
let selectedSpecialities_id = selectedSpecialities.map(speciality => speciality.id);
const activateSpeciality = (event, speciality) => {
    const index = selectedSpecialities_id.indexOf(speciality.id);

    if (index !== -1) { // Si la especialidad ya está seleccionada, la desactiva
        selectedSpecialities.splice(index, 1);
        selectedSpecialities_id.splice(index, 1);
        event.currentTarget.classList.remove('selected');
        specialitySubjectsData[speciality.id].forEach(subject => {
            subject.remove = true;
        });
        return;
    }

    event.currentTarget.classList.add('selected');

    selectedSpecialities.push(speciality);
    selectedSpecialities_id.push(speciality.id);

    // Solo agregar las asignaturas con valores predeterminados si no están ya en specialitySubjectsData
    if (!specialitySubjectsData[speciality.id]) {
        specialitySubjectsData[speciality.id] = [];
        speciality.subjects.forEach(subject => {
            specialitySubjectsData[speciality.id].push({
                id: subject.id,
                name: subject.name,
                is_collective: subject.is_collective,
                is_mandatory: null,
                school_hours: null,
                price: null,
                student_ratio: subject.student_ratio,
                remove: true,
            });
        });
    }
};

// Logic for the subjects of the speciality selected
let specialitySubjectsArray = Object.values(props.syllabi.speciality_subjects);
let specialitySubjectsData = {};

props.specialities.forEach(spec => {
    specialitySubjectsData[spec.id] = [];
    spec.subjects.forEach(subject => {
        let existingSubject = specialitySubjectsArray.find(s => s.id === subject.id);

        if (existingSubject) {
            specialitySubjectsData[spec.id].push({
                id: existingSubject.id,
                name: existingSubject.name,
                is_collective: existingSubject.is_collective,
                is_mandatory: existingSubject.is_mandatory === 1,
                school_hours: existingSubject.school_hours,
                price: existingSubject.price,
                student_ratio: existingSubject.student_ratio,
                remove: false,
            });
        } else {
            specialitySubjectsData[spec.id].push({
                id: subject.id,
                name: subject.name,
                is_collective: subject.is_collective,
                is_mandatory: false,
                school_hours: null,
                price: null,
                student_ratio: subject.student_ratio,
                remove: true,
            });
        }
    });
});

const updateSpecialitySubjectData = (specialityId, subjectId, field, value) => {
    if (selectedSpecialities_data[specialityId]) {
        let subject = selectedSpecialities_data[specialityId].subjects.find(s => s.id === subjectId);
        if (subject) {
            subject[field] = value;
        }
    }
};

// Logic for the subject selector
let selectedSubjects = Object.values(props.syllabi.subjects);
let selectedSubjects_id = selectedSubjects.map(subject => subject.id);
let selectedSubjects_data = {};
selectedSubjects.forEach(subject => {
    selectedSubjects_data[subject.id] = {
        id: subject.id,
        name: subject.name,
        is_mandatory: subject.is_mandatory === 1,
        school_hours: subject.school_hours,
        price: subject.price,
        student_ratio: subject.student_ratio,
    };
});
const activateSubject = (event, subject) => {
    const index = selectedSubjects_id.indexOf(subject.id);

    if (index !== -1) {
        selectedSubjects_id.splice(index, 1);
        delete selectedSubjects_data[subject.id];
        event.currentTarget.classList.remove('selected');
        // Add the disabled to the next button
        if (selectedSubjects_id.length === 0)
            document.getElementById('subjects-next').setAttribute('disabled', 'disabled');
        return;
    }

    event.currentTarget.classList.add('selected');

    selectedSubjects_id.push(subject.id);
    selectedSubjects_data[subject.id] = {
        id: subject.id,
        name: subject.name,
        is_mandatory: subject.is_mandatory === 1,
        school_hours: subject.school_hours,
        price: subject.price,
        student_ratio: subject.student_ratio,
        remove: false,
    }

    document.getElementById('specialities-next').removeAttribute('disabled');
};

// Every time we change the value of the input, we update the value of the subject_data
const updateSubjectData = (subjectId, field, value) => {
    if (selectedSubjects_data[subjectId]) {
        selectedSubjects_data[subjectId][field] = value;
    }
};

// Form logic
const form = useForm({
    id: props.syllabi.id,
    name: props.syllabi.name,
    age: props.syllabi.age,
    max_failed_subjects_to_pass: props.syllabi.max_failed_subjects_to_pass,
    course: null,
    degree: null,
    specialities: null,
    specialities_subjects_data: null,
    subjects_data: null,
});

// Submit the form
const submit = () => {
    form.name = document.getElementById('name').value;
    form.age = document.getElementById('age').value;
    form.degree = selectedDegree.id;
    form.course = selectedCourse.id;
    form.specialities = selectedSpecialities_id;
    form.specialities_data = selectedSpecialities_data;
    form.specialities_subjects_data = specialitySubjectsData;
    form.subjects_data = selectedSubjects_data;

    form.patch(updateRoute);
};

</script>

<template>
    <Head title="Editar Plan de Estudios" />

    <AuthenticatedLayout :croute="customroute">

        <form @submit.prevent="submit">

            <div class="page-title-container">
                <h1 class="page-title-main">
                    <Link class="custom-link" :href="route('syllabi.show')">
                    <i class="fa-solid fa-chevron-left back-icon"></i> Plan de Estudios
                    </Link>/
                </h1>

                <h1 class="page-title-sub">Actualizar</h1>
            </div>

            <div class="steps-content mt-4">
                <div :class="['step-content', { active: currentStep === 1 }]" id="step1">
                    <div class="syllabicreate-content">
                        <div class="syllabicreate-title">
                            1 - Actualice Grado
                        </div>
                        <div>
                            <div class="searchbar-container">
                                <div>
                                    <input class="searchbar" v-model="searchQuery" placeholder="Buscar grados" />
                                </div>
                            </div>
                        </div>
                        <div id="degree-selector">
                            <div v-for="degree in filteredDegrees" :key="degree.id" @click="activateDegree($event, degree)"
                                :class="{ selected: degree.id === selectedDegree.id }" class="syllabi-box"> {{ degree.name
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="buttons-container mt-3">
                        <ButtonGeneric @click="currentStep = 5" class="btn submit-button"
                            :class="{ 'opacity-25, ': form.processing }">
                            Actualizar
                        </ButtonGeneric>
                    </div>
                </div>

                <div :class="['step-content', { active: currentStep === 2 }]" id="step2">
                    <div class="syllabicreate-content">
                        <div class="syllabicreate-title">
                            2 - Actualice Curso
                        </div>
                        <div>
                            <div class="searchbar-container">
                                <div>
                                    <input class="searchbar" v-model="searchQuery" placeholder="Buscar Cursos" />
                                </div>
                            </div>
                        </div>
                        <div id="course-selector">
                            <div v-for="course in filteredCourses" :key="course.id" @click="activateCourse($event, course)"
                                :class="{ selected: course.id === selectedCourse.id }" class="syllabi-box"> {{
                                    course.name
                                }}
                            </div>
                        </div>
                    </div>
                    <div class="buttons-container mt-3">
                        <ButtonGeneric @click="currentStep = 5" class="btn submit-button"
                            :class="{ 'opacity-25, ': form.processing }">
                            Actualizar
                        </ButtonGeneric>
                    </div>
                </div>

                <div :class="['step-content', { active: currentStep === 3 }]" id="step3">
                    <div class="syllabicreate-content">
                        <div class="syllabicreate-title">
                            3 - Actualice Especialidades
                        </div>
                        <div>
                            <div class="searchbar-container">
                                <div>
                                    <input class="searchbar" v-model="searchQuery" placeholder="Buscar Cursos" />
                                </div>
                            </div>
                        </div>
                        <div id="speciality-selector">
                            <div v-for="speciality in filteredSpecialities" :key="speciality.id"
                                @click="activateSpeciality($event, speciality)"
                                :class="{ selected: isSelectedSpeciality(speciality) }" class="syllabi-box"> {{
                                    speciality.name }}
                            </div>
                        </div>
                    </div>
                    <div class="buttons-container mt-3">
                        <ButtonGeneric @click="currentStep = 5" class="btn submit-button"
                            :class="{ 'opacity-25, ': form.processing }">
                            Actualizar
                        </ButtonGeneric>
                    </div>
                </div>


                <div :class="['step-content', { active: currentStep === 4 }]" id="step4">
                    <div class="syllabicreate-content">
                        <div class="syllabicreate-title">
                            4 - Actualice Asignaturas
                        </div>
                        <div>
                            <div class="searchbar-container">
                                <div>
                                    <input class="searchbar" v-model="searchQuery" placeholder="Buscar Cursos" />
                                </div>
                            </div>
                        </div>

                        <div id="subject-selector">
                            <div v-for="subject in filteredSubjects" :key="subject.id"
                                @click="activateSubject($event, subject)" class="syllabi-box"
                                :class="{ selected: selectedSubjects_id.includes(subject.id) }"> {{
                                    subject.name }}
                            </div>
                        </div>
                    </div>
                    <div class="buttons-container mt-3">
                        <ButtonGeneric @click="currentStep = 5" class="btn submit-button"
                            :class="{ 'opacity-25, ': form.processing }">
                            Actualizar
                        </ButtonGeneric>
                    </div>
                </div>
                <div :class="['step-content', { active: currentStep === 5 }]" id="step5">
                    <div>
                        <div class="row">
                            <div class="column">
                                <div class="module">
                                    <div class="module-title">Grado</div>
                                    <div class="module-selected">{{ selectedDegree.name }}</div>
                                    <button type="button" class="btn btn-link" @click="currentStep = 1">
                                        Cambiar
                                    </button>
                                </div>
                            </div>

                            <div class="column">
                                <div class="module">
                                    <div class="module-title">Curso</div>
                                    <div class="module-selected">{{ selectedCourse.name }}</div>
                                    <button type="button" class="btn btn-link" @click="currentStep = 2">
                                        Cambiar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="column">
                                <div class="module">
                                    <InputLabel for="name" class="module-title extra-margin"
                                        value="Nombre del plan de estudios" />
                                    <TextInput id="name" type="text" class="mt-1 block w-full form-control"
                                        v-model="form.name" />
                                </div>
                            </div>

                            <div class="column">
                                <div class="module">
                                    <InputLabel for="age" class="module-title extra-margin" value="Edad *" />
                                    <input id="age" type="number" min="0" max="99" class="form-control" v-model="form.age"
                                        required>
                                </div>
                            </div>

                            <div class="column">
                                <div class="module">
                                    <InputLabel for="max_failed_subjects_to_pass" class="module-title extra-margin"
                                        value="Asignaturas suspensas máx. *" />
                                    <input id="max_failed_subjects_to_pass" type="number" min="0" max="99"
                                        class="form-control" v-model="form.max_failed_subjects_to_pass" required>
                                </div>
                            </div>
                        </div>

                        <div class="row gap-4">
                            <div class="column half">
                                <div class="module-column-subject">
                                    <div class="module-title-subject extra-margin">Especialidades</div>
                                    <button type="button" class="btn btn-link" @click="currentStep = 3">
                                        Cambiar
                                    </button>


                                </div>
                            </div>

                            <div class="column half">
                                <div class="module-column-subject">
                                    <div class="module-title-subject extra-margin">Asignaturas</div>
                                    <button type="button" class="btn btn-link" @click="currentStep = 4">
                                        Cambiar
                                    </button>
                                    <template v-for="(subject, index) in selectedSubjects_data" :key="subject.id">
                                        <div class="module-subject">
                                            <span class="subject-name">{{ subject.name }}</span>
                                            <div class="underline"></div>
                                        </div>
                                        <table class="table-target">
                                            <tbody>

                                                <!-- Fila para el nombre de la asignatura -->

                                                <!-- Fila para los títulos de los detalles -->
                                                <tr class="table-row-detail">
                                                    <td class="table-cell-text">Obligatoria</td>
                                                    <td class="table-cell-text">Hr. Lectivas</td>
                                                    <td class="table-cell-text">Precio</td>
                                                    <td class="table-cell-text">Ratio</td>
                                                </tr>
                                                <!-- Fila para los inputs de los detalles -->
                                                <tr class="table-row-detail">
                                                    <td class="table-cell-input">
                                                        <input class="form-check-input cursor-pointer" type="checkbox"
                                                            :checked="subject.is_mandatory"
                                                            @change="updateSubjectData(subject.id, 'is_mandatory', $event.target.checked)">
                                                    </td>
                                                    <td class="table-cell-input">
                                                        <input type="number" step=".01" max="99" min="0"
                                                            class="form-control short-input" :value="subject.school_hours"
                                                            @input="updateSubjectData(subject.id, 'school_hours', $event.target.value)">
                                                    </td>
                                                    <td class="table-cell-input">
                                                        <input type="number" step=".01" max="999" min="0"
                                                            class="form-control short-input" :value="subject.price"
                                                            @input="updateSubjectData(subject.id, 'price', $event.target.value)">
                                                    </td>
                                                    <td class="table-cell-input">
                                                        <input type="number" max="99" min="0"
                                                            class="form-control short-input" :value="subject.student_ratio"
                                                            @input="updateSubjectData(subject.id, 'student_ratio', $event.target.value)">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </template>
                                </div>
                            </div>

                        </div>
                        <div>
                            <div>
                                <div>
                                    <div>Especialidades</div>
                                    <button type="button" class="btn btn-link" @click="currentStep = 3">
                                        Cambiar
                                    </button>
                                    <div v-if="selectedSpecialities.length > 0">
                                        <div v-for="speciality in selectedSpecialities" :key="speciality.id">
                                            <div>{{ speciality.name }}</div>

                                            <!-- Itera sobre las asignaturas de la especialidad -->
                                            <div v-for="subject in specialitySubjectsData[speciality.id]" :key="subject.id">
                                                {{ subject.name }}

                                                <label>
                                                    Obligatoria:
                                                    <input type="checkbox" class="form-check-input cursor-pointer"
                                                        :checked="subject.is_mandatory"
                                                        @change="updateSpecialitySubjectData(speciality.id, subject.id, 'is_mandatory', $event.target.checked)">
                                                </label>

                                                <label>
                                                    Horas Lectivas:
                                                    <input type="number" max="99" min="0" step=".01" class="form-control"
                                                        :value="subject.school_hours"
                                                        @input="updateSpecialitySubjectData(speciality.id, subject.id, 'school_hours', parseFloat($event.target.value))">
                                                </label>

                                                <label>
                                                    Precio:
                                                    <input type="number" max="999" min="0" step=".01" class="form-control"
                                                        :value="subject.price"
                                                        @input="updateSpecialitySubjectData(speciality.id, subject.id, 'price', parseFloat($event.target.value))">
                                                </label>

                                                <label v-if="subject.is_collective">
                                                    Ratio de estudiantes:
                                                    <input type="number" max="99" min="0" class="form-control"
                                                        :value="subject.student_ratio"
                                                        @input="updateSpecialitySubjectData(speciality.id, subject.id, 'student_ratio', $event.target.value)">
                                                </label>

                                                <label>
                                                    No añadir:
                                                    <input type="checkbox" class="form-check-input cursor-pointer"
                                                        :checked="subject.remove"
                                                        @change="updateSpecialitySubjectData(speciality.id, subject.id, 'remove', $event.target.checked)">
                                                </label>

                                            </div>
                                        </div>
                                    </div>

                                    <div v-else>
                                        Sin especialidades
                                    </div>
                                    <button type="button" class="btn btn-link" @click="currentStep = 3">
                                        Cambiar
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="buttons-container mt-3">

                        <ButtonDanger v-if="permissions.includes('syllabi.destroy')" type="button" class="btn w-100"
                            :disabled="form.processing" data-bs-togle="modal" data-bs-target="#destroySyllabi">
                            Borrar
                        </ButtonDanger>

                        <ButtonGeneric class="btn submit-button w-100" :class="{ 'opacity-25,': form.processing }"
                            :disabled="form.processing">
                            Actualizar
                        </ButtonGeneric>


                    </div>

                    <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0"
                        class="text-danger mt-2 text-center">
                        <ul>
                            <li v-for="(error, field) in $page.props.errors">{{ error }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>

        <Modal id="destroySyllabi">
            <template #modal-header>
                Eliminar Plan de Estudios
            </template>

            <template #modal-body>
                <RemoveSyllabiModal :syllabi_id="syllabi.id" />
            </template>
        </Modal>

    </AuthenticatedLayout>
</template>

<style scoped>
.buttons-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    /* Puedes ajustar este valor para cambiar el espacio entre los botones */
}

.steps-nav {
    display: flex;
    justify-content: space-between;
    padding: 0 10px;
    gap: 10px;
    position: relative;
    /* Agregado para el pseudo-elemento */
}

.step-item {
    position: relative;
    /* Para que el pseudo-elemento se base en este */
    padding: .5rem 5rem .5rem 5rem;
    color: #555;
    border: none;
    border-radius: 50px;
    background-color: #fff;
    transition: background-color 0.3s, border-color 0.3s, color 0.3s;
    cursor: pointer;
    z-index: 2;
    /* Para que el step-item esté por encima de la línea */
}

.step-item::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 0.15rem solid #A8A8A8;
    /* Este es el borde por defecto para todos los .step-item */
    border-radius: 50px;
    z-index: 1;
}


/* Línea usando el pseudo-elemento ::before */
.step-item::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 100%;
    width: 100%;
    /* Ajustado para tener en cuenta la eliminación del último step-item */
    height: 2px;
    background-color: #A8A8A8;
    transform: translateY(-50%);
    z-index: 0;
    /* Debajo del step-item */
}

.step-item.active::after,
.step-item.completed::after {
    border-color: #3C7FF8;
}

.step-item.completed:not(.active)::after {
    border-color: #2B5DB6;
}


/* No queremos una línea en el último step-item */
.step-item:last-child::before {
    content: none;
}

.step-item:hover {
    background-color: #e6e6e6;
}

.step-item.active {
    background-color: #3C7FF8;
    border-color: #3C7FF8;
    color: #fff;
}

.step-item.completed {
    background-color: #2B5DB6;
    border-color: #2B5DB6;
    color: #fff;
}

.step-item.active.completed {
    border-color: #3C7FF8;
    background-color: #3C7FF8;
}

.steps-content {
    padding: 20px;
}

.step-content {
    display: none;
    position: relative;
}

.step-content.active {
    display: block;
}

.next-btn,
.prev-btn {
    font-size: 1.3rem;
    padding: 10px 20px;
    background-color: transparent;
    color: #3C7FF8;
    border: 1px solid #3C7FF8;
    border-radius: 30px;
    cursor: pointer;
    transition: transform ease-in-out 0.15s;
    /* Transición para la transformación */

}

.next-btn:hover,
.prev-btn:hover {
    background-color: #3C7FF8;
    color: white;
}

.syllabi-box {
    padding: 1rem;
    border-radius: 8rem;
    /* Esquinas redondeadas */
    margin-bottom: 0.5rem;
    /* Espacio entre elementos */
    cursor: pointer;
    /* Cambia el cursor al pasar el mouse por encima */
    transition: background-color 0.3s;
    /* Transición suave al cambiar el fondo */
    width: calc(50% - 1rem);
    box-sizing: border-box;
    text-align: center;
    box-shadow: 0px 0px 8px 0px rgba(0, 0, 0, 0.20);
    font-size: 1.2rem;
    font-weight: 400;
    border: 0.1rem solid white;
    transform: scale(1);
    /* Tamaño inicial sin escala adicional */
    transition: transform ease-in-out 0.15s;
    /* Transición para la transformación */
}

.syllabi-box:hover {
    transform: scale(1.015);
    border: 0.1rem solid #3C7FF8;
}

.selected {
    background-color: #3C7FF8;
    color: white;
    font-weight: 500;
    border: 0.1rem solid #3C7FF8;
}

.page-title-container {
    display: flex;
    align-items: center;
    /* Esto es para que ambos estén alineados verticalmente */
    margin-bottom: 2rem;
}

.page-title-main {
    font-weight: 600;
    /* Hacerlo más grueso */
    font-size: 1.8rem;
    color: #2B5DB6;
    /* El azul oscuro que mencionaste */
}

.page-title-sub {
    font-weight: normal;
    /* Hacerlo normal */
    font-size: 1.8rem;
    margin-left: 0.5rem;
    /* Pequeño margen a la izquierda para separar de la parte principal */
    color: #2B5DB6;
    /* El azul oscuro que mencionaste */
}

.navHidden {
    display: none;
}

.syllabicreate-content {
    border-radius: 4rem;
    box-shadow: 0 0rem 1rem rgba(0, 0, 0, 0.15);
    padding: 2rem;
    background-color: #ffffff;
    gap: 2rem;
    margin-top: 0.5rem;
    position: relative;
}

.syllabicreate-title {
    text-align: center;
    font-weight: 600;
    font-size: 2rem;
    color: #3C7FF8;
    /* Reemplaza este valor si tienes un color azul oscuro diferente */
    margin-bottom: 1rem;
}

.searchbar {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50rem;
    position: relative;
    height: 3rem;
    border-radius: 8rem;
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.searchbar-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 5rem;
    /* Ajusta este valor según tus necesidades. */
}

.icon-next {
    color: #3C7FF8;
    font-size: 2.5rem;
}


#degree-selector {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    max-height: 15rem;
    overflow-y: auto;
    padding: 0.5rem 0;

}

#course-selector {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    max-height: 15rem;
    overflow-y: auto;
    padding: 0.5rem 0;

}

#speciality-selector {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    max-height: 15rem;
    overflow-y: auto;
    padding: 0.5rem 0;
}

#subject-selector {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    max-height: 15rem;
    overflow-y: auto;
    padding: 0.5rem 0;
}

.row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    /* Espaciado entre filas */
}

.column {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.column-age {
    display: flex;
    flex-direction: column;
    flex-basis: 10rem;
    margin-right: 1rem;

    /* Espaciado entre columnas */
    &:last-child {
        margin-right: 0;
        /* No hay margen en la última columna */
    }
}

.module {
    border-radius: 2rem;
    box-shadow: 0 0rem 1rem rgba(0, 0, 0, 0.15);
    padding: 2rem;
    background-color: #ffffff;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    flex: 1;
}

.module-column-subject {
    border-radius: 2rem;
    box-shadow: 0 0rem 1rem rgba(0, 0, 0, 0.15);
    padding: 4rem;
    background-color: #ffffff;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex: 1;
}

.module-title {
    align: center;
    font-weight: 500;
    color: #2a6cc9;
    font-size: 1.3rem;
}

.module-title-subject {
    text-align: center;
    font-weight: 500;
    color: #2a6cc9;
    font-size: 1.3rem;
}

.module-subject {
    display: flex;
    align-items: center;
}

.subject-name {
    white-space: nowrap;
    /* Evitar que el texto se parta en varias líneas */
    font-weight: 500;
    font-size: 1.2rem;
    padding-bottom: 0.5rem;
    padding-top: 1.5rem;
}

.speciality-name {
    white-space: nowrap;
    /* Evitar que el texto se parta en varias líneas */
    font-weight: 600;
    font-size: 1.2rem;
    padding-top: 1.5rem;
    color: #2a6cc9;
}

.subject-speciality-name {
    white-space: nowrap;
    /* Evitar que el texto se parta en varias líneas */
    font-weight: 500;
    font-size: 1.1rem;
    padding-bottom: 0.5rem;
    padding-top: 1.5rem;
}

.underline {
    flex-grow: 1;
    /* Hacer que la línea ocupe el espacio restante en la fila */
    height: 0.2rem;
    background: #000;
    /* El color que prefieras para la línea */
    margin-top: 1.8rem;
    /* Un pequeño margen entre el texto y la línea */
    margin-left: 0.5rem;
}

.icon-trash {
    margin-left: auto;
    cursor: pointer;
    padding-left: 1rem;
    transition: transform ease-in-out 0.3s;
    /* Transición para la transformación */
}

.icon-trash.rotated {
    transform: rotate(45deg);
}

.extra-margin {
    margin-bottom: 0.75rem;
}

.module-selected {
    font-weight: 600;
    font-size: 2rem;
}

.modified-color {
    color: #8d8c8c;
    /* Cambia este valor al color deseado */
    font-weight: 400;
}


.form-control {
    border-radius: 2rem;
    border: 1px solid black;
    background: #fff;
    font-size: 1rem;
    text-align: center;
    width: 100%;
}

.table-header-text {
    font-weight: 500;
    font-size: 1rem;
    color: #555;
}

.custom-link {
    text-decoration: none;
    color: #2B5DB6;
    /* Esto asegura que el color se aplique tanto al texto como al ícono */
}

/* Para mantener el color incluso cuando se pasa el cursor por encima */
.custom-link:hover {
    color: #2a6cc9;
}

.back-icon {
    font-size: 1.5rem;
}

.table-row-detail {
    color: #757575;
}

.table-cell-text,
.table-cell-input {
    text-align: center;
    padding-left: 1.25rem;
    padding-right: 1.25rem;


}

.table-target {
    width: 100%;
}

.underline {
    border-bottom: 1px solid black;
}



/* Ocultar flechas en inputs de tipo number para Firefox */
input[type='number']::-webkit-inner-spin-button,
input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    /* Para Chrome y Safari */
    margin: 0;
    /* Para Firefox */
}

/* Para Chrome, Safari y Edge */
input[type='number']::-webkit-inner-spin-button,
input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Para Firefox */
input[type='number'] {
    -moz-appearance: textfield;
}
</style>