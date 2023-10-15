<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import ButtonOutline from '@/Components/ButtonOutline.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, reactive, computed } from 'vue';

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

const changeStepNext = () => {
    searchQuery.value = '';  // Limpiamos searchQuery.
    currentStep.value++;     // Incrementamos el paso actual.
};

const changeStepBack = () => {
    searchQuery.value = '';  // Limpiamos searchQuery.
    currentStep.value--;     // Incrementamos el paso actual.
};

const isSelectedSubject = (subject) => {
    return selectedSubjects_id.includes(subject.id);
};

const props = defineProps({
    customroute: String,
    degrees: Object,
    courses: Object,
    specialities: Object,
    subjects: Object,
    schoolYear: Object,
});

const createRoute = route('syllabi.store');

const currentStep = ref(1);

let selectedDegree = [];
const activateDegree = (event, degree) => {
    const degreeSelector = document.getElementById('degree-selector');
    degreeSelector.querySelectorAll('.selected').forEach((element) => {
        element.classList.remove('selected');
    });

    event.currentTarget.classList.add('selected');

    // Remove the disabled from the next button
    document.getElementById('degree-next').removeAttribute('disabled');

    selectedDegree = degree;
    document.getElementById('max_failed_subjects_to_pass').value = selectedDegree.max_failed_subjects_to_pass;
};

let selectedCourse = [];
const activateCourse = (event, course) => {
    const courseSelector = document.getElementById('course-selector');
    courseSelector.querySelectorAll('.selected').forEach((element) => {
        element.classList.remove('selected');
    });

    event.currentTarget.classList.add('selected');

    // Remove the disabled from the next button
    document.getElementById('course-next').removeAttribute('disabled');

    selectedCourse = course;
};

let selectedSpecialities_id = [];
let selectedSpecialities_data = reactive({});
const activateSpeciality = (event, speciality) => {
    const index = selectedSpecialities_id.indexOf(speciality.id);

    if (index !== -1) {
        selectedSpecialities_id.splice(index, 1);
        delete selectedSpecialities_data[speciality.id];
        event.currentTarget.classList.remove('selected');
        return;
    }

    event.currentTarget.classList.add('selected');

    selectedSpecialities_id.push(speciality.id);
    selectedSpecialities_data[speciality.id] = {
        id: speciality.id,
        name: speciality.name,
        subjects: speciality.subjects.map(subject => ({
            id: subject.id,
            name: subject.name,
            is_collective: subject.is_collective,
            is_mandatory: subject.is_mandatory === 1,
            school_hours: subject.school_hours,
            price: subject.price,
            student_ratio: subject.student_ratio,
            remove: false,
        }))
    };
};


const updateSpecialitySubjectData = (specialityId, subjectId, field, value) => {
    if (selectedSpecialities_data[specialityId]) {
        let subject = selectedSpecialities_data[specialityId].subjects.find(s => s.id === subjectId);
        if (subject) {
            subject[field] = value;
        }
    }
};


let selectedSubjects_id = [];
let selectedSubjects_data = {};
const activateSubject = (event, subject) => {
    const index = selectedSubjects_id.indexOf(subject.id);

    if (index !== -1) {
        selectedSubjects_id.splice(index, 1);
        delete selectedSubjects_data[subject.id];
        event.currentTarget.classList.remove('selected');
        // Add the disabled to the next button
        if (selectedSubjects_id.length === 0)
            document.getElementById('subject-next').setAttribute('disabled', 'disabled');
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
    }

    document.getElementById('subject-next').removeAttribute('disabled');
};

const updateSubjectData = (subjectId, field, value) => {
    if (selectedSubjects_data[subjectId]) {
        selectedSubjects_data[subjectId][field] = value;
    }
};


const form = useForm({
    name: '',
    age: null,
    max_failed_subjects_to_pass: null,
    course: null,
    degree: null,
    specialities_data: null,
    subjects_data: null,
});

const submit = () => {
    form.name = document.getElementById('name').value;
    form.age = document.getElementById('age').value;
    form.max_failed_subjects_to_pass = document.getElementById('max_failed_subjects_to_pass').value;
    form.degree = selectedDegree.id;
    form.course = selectedCourse.id;
    form.specialities_data = selectedSpecialities_data;
    form.subjects_data = selectedSubjects_data;

    form.post(createRoute);
};

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



</script>

<template>
    <Head title="Crear Plan de Estudios" />

    <AuthenticatedLayout :croute="customroute">

        <form @submit.prevent="submit">

            <div class="page-title-container">
                <h1 class="page-title-main">
                    <Link class="custom-link" :href="route('syllabi.show')">
                    <i class="fa-solid fa-chevron-left back-icon"></i> Plan de Estudios
                    </Link>/
                </h1>

                <h1 class="page-title-sub">Crear Plan</h1>
            </div>

            <div class="steps-nav" :class="{ navHidden: currentStep === 5 }">
                <div :class="['step-item', { active: currentStep === 1, completed: currentStep > 1 }]" data-step="1">Grado
                </div>
                <div :class="['step-item', { active: currentStep === 2, completed: currentStep > 2 }]" data-step="2">Curso
                </div>
                <div :class="['step-item', { active: currentStep === 3, completed: currentStep > 3 }]" data-step="3">
                    Especialidad</div>
                <div :class="['step-item', { active: currentStep === 4, completed: currentStep > 4 }]" data-step="4">
                    Asignatura</div>
            </div>

            <div class="steps-content mt-4">

                <div :class="['step-content', { active: currentStep === 1 }]" id="step1">


                    <div class="syllabicreate-content">
                        <div class="syllabicreate-title">
                            1 - Seleccione Grado
                        </div>
                        <div>
                            <div class="searchbar-container">
                                <div>
                                    <input class="searchbar" v-model="searchQuery" placeholder="Buscar grados" />
                                </div>
                            </div>
                            <div id="degree-selector">
                                <div v-for="degree in filteredDegrees" :key="degree.id"
                                    :class="{ 'selected': isSelectedDegree(degree) }"
                                    @click="activateDegree($event, degree)" class="syllabi-box">
                                    {{ degree.name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-center gap-2 mt-4">
                        <button type="button" @click="changeStepNext" class="next-btn" disabled
                            id="degree-next">&gt;</button>
                    </div>

                </div>

                <div :class="['step-content', { active: currentStep === 2 }]" id="step2">

                    <div class="syllabicreate-content">
                        <div class="syllabicreate-title">
                            2 - Seleccione Curso
                        </div>
                        <div>
                            <div class="searchbar-container">
                                <div>
                                    <input class="searchbar" v-model="searchQuery" placeholder="Buscar cursos" />
                                </div>
                            </div>
                        </div>

                        <div id="course-selector">
                            <div v-for="course in filteredCourses" :key="course.id"
                                :class="{ 'selected': isSelectedCourse(course) }" @click="activateCourse($event, course)"
                                class="syllabi-box">
                                {{ course.name }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-row justify-content-center gap-3 mt-4">
                        <button type="button" @click="changeStepBack" class="prev-btn">&lt;</button>

                        <button type="button" @click="changeStepNext" class="next-btn" disabled
                            id="course-next">&gt;</button>
                    </div>
                </div>

                <div :class="['step-content', { active: currentStep === 3 }]" id="step3">

                    <div class="syllabicreate-content">
                        <div class="syllabicreate-title">
                            3 - Seleccione Especialidades
                        </div>
                        <div>
                            <div class="searchbar-container">
                                <div>
                                    <input class="searchbar" v-model="searchQuery" placeholder="Buscar especialidades" />
                                </div>
                            </div>
                        </div>

                        <div id="speciality-selector">
                            <div v-for="speciality in filteredSpecialities" :key="speciality.id"
                                :class="{ 'selected': isSelectedSpeciality(speciality) }"
                                @click="activateSpeciality($event, speciality)" class="syllabi-box">
                                {{ speciality.name }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-center gap-3 mt-4">
                        <button type="button" @click="changeStepBack" class="prev-btn">&lt;</button>
                        <button type="button" @click="changeStepNext" class="next-btn" id="speciality-next">&gt;</button>
                    </div>
                </div>

                <div :class="['step-content', { active: currentStep === 4 }]" id="step4">
                    <div class="syllabicreate-content">
                        <div class="syllabicreate-title">
                            4 - Seleccione Asignaturas
                        </div>
                        <div>
                            <div class="searchbar-container">
                                <div>
                                    <input class="searchbar" v-model="searchQuery" placeholder="Buscar asignaturas" />
                                </div>
                            </div>

                            <div id="subject-selector">
                                <div v-for="subject in filteredSubjects" :key="subject.id"
                                    :class="{ 'selected': isSelectedSubject(subject) }"
                                    @click="activateSubject($event, subject)" class="syllabi-box">
                                    {{ subject.name }}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-center gap-3 mt-4">
                        <button type="button" @click="changeStepBack" class="prev-btn">&lt;</button>

                        <button type="button" @click="changeStepNext" class="next-btn" disabled
                            id="subject-next">&gt;</button>
                    </div>
                </div>

                <div :class="['step-content', { active: currentStep === 5 }]" id="step5">
                    <!-- Primera fila -->
                    <div class="row">
                        <!-- Columna 1: Grado -->
                        <div class="column">
                            <div class="module">
                                <div class="module-title">Grado</div>
                                <div class="module-selected">{{ selectedDegree.name }}</div>
                            </div>
                        </div>

                        <!-- Columna 2: Curso -->
                        <div class="column">
                            <div class="module">
                                <div class="module-title">Curso</div>
                                <div class="module-selected">{{ selectedCourse.name }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Columna 1: Nombre-->
                        <div class="column">
                            <div class="module">
                                <InputLabel for="name" class="module-title extra-margin"
                                    value="Nombre del plan de estudios" />
                                <TextInput id="name" type="text" class="mt-1 block w-full form-control" />
                            </div>
                        </div>

                        <!-- Columna 2: Edad -->
                        <div class="column">
                            <div class="module">

                                <InputLabel for="age" class="module-title extra-margin" value="Edad *" />
                                <input id="age" type="number" min="0" max="99" class="form-control" required>
                            </div>
                        </div>

                        <!--- Columna 3: Asignaturas Suspensas -->

                        <div class="column">
                            <div class="module">

                                <InputLabel for="max_failed_subjects_to_pass" class="module-title extra-margin"
                                    value="Asignaturas suspensas máx. *" />
                                <input id="max_failed_subjects_to_pass" type="number" min="0" max="99" class="form-control"
                                    :value="selectedDegree.max_failed_subjects_to_pass" required>
                            </div>
                        </div>
                    </div>




                    <!-- Segunda fila -->
                    <div class="row gap-4">
                        <!-- Columna 1: Especialidades -->
                        <div class="column half">
                            <div class="module-column-subject">
                                <div class="module-title-subject extra-margin">Especialidades</div>
                                <div v-if="Object.keys(selectedSpecialities_data).length > 0">
                                    <div v-for="(specialityData, specialityId) in selectedSpecialities_data"
                                        :key="specialityId">
                                        <div class="module-subject">
                                            <span class="speciality-name">{{ specialityData.name }}</span>
                                        </div>
                                        <div v-for="subject in specialityData.subjects" :key="subject.id">
                                            <div class="module-subject">
                                                <span class="subject-speciality-name"
                                                    :class="{ 'modified-color': subject.remove }">{{ subject.name }}</span>
                                                <div class="underline" :class="{ 'modified-color': subject.remove }"></div>
                                                <i class="fa-regular fa-xmark icon-trash"
                                                    :class="{ rotated: subject.remove }"
                                                    @click="toggleFields(specialityId, subject.id)">
                                                </i>
                                            </div>
                                            <div v-if="subject.remove === false">
                                                <table class="table-target">
                                                    <tbody>
                                                        <tr class="table-row-detail">
                                                            <td class="table-cell-text">Obligatoria</td>
                                                            <td class="table-cell-text">Hr. Lectivas</td>
                                                            <td class="table-cell-text">Precio</td>
                                                            <td class="table-cell-text">Ratio</td>
                                                        </tr>
                                                        <tr class="table-row-detail">
                                                            <td class="table-cell-input">
                                                                <input type="checkbox"
                                                                    class="form-check-input cursor-pointer"
                                                                    @change="updateSpecialitySubjectData(specialityId, subject.id, 'is_mandatory', $event.target.checked)">
                                                            </td>
                                                            <td class="table-cell-input">
                                                                <input type="number" max="99" min="0" step=".01"
                                                                    class="form-control short-input"
                                                                    @input="updateSpecialitySubjectData(specialityId, subject.id, 'school_hours', $event.target.value)">
                                                            </td>
                                                            <td class="table-cell-input">
                                                                <input type="number" max="999" min="0" step=".01"
                                                                    class="form-control short-input"
                                                                    @input="updateSpecialitySubjectData(specialityId, subject.id, 'price', $event.target.value)">
                                                            </td>
                                                            <td class="table-cell-input">
                                                                <input type="number" max="99" min="0"
                                                                    class="form-control short-input"
                                                                    :value="subject.student_ratio"
                                                                    @input="updateSpecialitySubjectData(specialityId, subject.id, 'student_ratio', $event.target.value)">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Columna 2: Asignaturas -->
                        <div class="column half">
                            <div class="module-column-subject">
                                <div class="module-title-subject extra-margin">Asignaturas</div>
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
                                                    <input type="number" max="99" min="0" class="form-control short-input"
                                                        :value="subject.student_ratio"
                                                        @input="updateSubjectData(subject.id, 'student_ratio', $event.target.value)">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </template>
                            </div>
                        </div>

                    </div>

                    <div class="buttons-container">
                        <ButtonOutline @click="changeStepBack">
                            Atrás
                        </ButtonOutline>
                        <ButtonGeneric class="btn submit-button" :class="{ 'opacity-25,': form.processing }"
                            :disabled="form.processing">
                            Crear
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