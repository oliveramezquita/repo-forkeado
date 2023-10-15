<script setup>
import { ref, computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

import Calendar from '@/Components/Amadeus/Calendar/Calendar.vue';

import EnrollmentLayout from '@/Layouts/EnrollmentLayout.vue';

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

/*
* Logic to control the page props coming from the controller
*/
const props = defineProps({
    specialities: {
        type: Array,
        required: true,
    },
});

/*
* Logic to control the form steps and the name.
*/
const currentStep = ref(1);
const steps = [
    { 
        step: 1, 
        title: "Título del paso", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        step: 2, 
        title: "Datos del alumno", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        step: 3, 
        title: "Experiencia previa", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        step: 4, 
        title: "Plan de estudios", 
        subtitle: "Grado Elemental 1º",
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        step: 5, 
        title: "Disponibilidad horaria", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        step: 6, 
        title: "Resumen", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        step: 7, 
        title: "¡Matriculación completada!", 
        description: "La jefatura de estudios revisará su solicitud."
    },
    // Casos extra especiales
    { 
        // Este es el case 8
        step: 2, 
        title: "Datos del representante legal", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        // Este es el case 9
        step: 2, 
        title: "Datos de representantes legales extra", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        // Este es el case 10
        step: 2, 
        title: "Datos de representantes legal", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        // Este es el case 11
        step: 2, 
        title: "Datos del alumno", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    { 
        // Este es el case 12
        step: 3, 
        title: "Experiencia previa", 
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
    {
        // Este es el caso 13
        step: 5,
        title: "Disponibilidad horaria",
        description: "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis."
    },
];

/*
* Logic to control the form steps and validate them, before continuing to the next step.
*/
const stepsHistory = ref([]);

const moveToStep = (step) => {
    stepsHistory.value.push(currentStep.value);
    currentStep.value = step;
};

const validaAndMoveToStep = (current, next) => {
    if (validateStep(current))
        moveToStep(next);
}

let isValid = false;
const validateStep = (step) => {
    switch (step) {
        case 2:
            // Valida los inputs del estudiante
            const studentNameEl = document.getElementById('student_name');
            const studentSurnameEl = document.getElementById('student_surname');
            const studentBirthDateEl = document.getElementById('student_birth_date');
            const studentDNIEl = document.getElementById('student_dni');
            const studentGenderEl = document.getElementById('student_gender');

            isValid = true; // suponemos que es válido a menos que un campo demuestre lo contrario

            // Validar studentName
            if (studentNameEl.value.trim()) {
                studentNameEl.classList.remove('input-invalid');
            } else {
                studentNameEl.classList.add('input-invalid');
                isValid = false;
            }

            // Validar studentSurname
            if (studentSurnameEl.value.trim()) {
                studentSurnameEl.classList.remove('input-invalid');
            } else {
                studentSurnameEl.classList.add('input-invalid');
                isValid = false;
            }

            // Validar studentBirthDate
            if (studentBirthDateEl.value) {
                studentBirthDateEl.classList.remove('input-invalid');
            } else {
                studentBirthDateEl.classList.add('input-invalid');
                isValid = false;
            }

            // Validar studentDNI
            if (studentDNIEl.value.trim()) {
                studentDNIEl.classList.remove('input-invalid');
            } else {
                studentDNIEl.classList.add('input-invalid');
                isValid = false;
            }

            if (studentGenderEl.value != 0) {
                studentGenderEl.classList.remove('input-invalid');
            } else {
                studentGenderEl.classList.add('input-invalid');
                isValid = false;
            }

            return isValid;

        case 8:
            // Recoge los elementos
            const guardianNameEl = document.getElementById('guardian_name');
            const guardianSurnameEl = document.getElementById('guardian_surname');
            const guardianBirthDateEl = document.getElementById('guardian_birth_date');
            const guardianDNIEl = document.getElementById('guardian_dni');
            const guardianPhoneEl = document.getElementById('guardian_phone');
            const guardianGenderEl = document.getElementById('guardian_gender');

            isValid = true; // suponemos que es válido a menos que un campo demuestre lo contrario

            // Validar guardianName
            if (guardianNameEl.value) {
                guardianNameEl.classList.remove('input-invalid');
            } else {
                guardianNameEl.classList.add('input-invalid');
                isValid = false;
            }

            // Validar guardianSurname
            if (guardianSurnameEl.value) {
                guardianSurnameEl.classList.remove('input-invalid');
            } else {
                guardianSurnameEl.classList.add('input-invalid');
                isValid = false;
            }

            // Y así sucesivamente para los otros campos...
            if (guardianBirthDateEl.value) {
                guardianBirthDateEl.classList.remove('input-invalid');
            } else {
                guardianBirthDateEl.classList.add('input-invalid');
                isValid = false;
            }

            if (guardianDNIEl.value) {
                guardianDNIEl.classList.remove('input-invalid');
            } else {
                guardianDNIEl.classList.add('input-invalid');
                isValid = false;
            }

            if (guardianPhoneEl.value) {
                guardianPhoneEl.classList.remove('input-invalid');
            } else {
                guardianPhoneEl.classList.add('input-invalid');
                isValid = false;
            }

            if (guardianGenderEl.value != 0) {
                guardianGenderEl.classList.remove('input-invalid');
            } else {
                guardianGenderEl.classList.add('input-invalid');
                isValid = false;
            }

            return isValid;
        
        case 10:
            // Recoge los elementos
            const guardianEmailEl = document.getElementById('guardian_email');
            const guardianPasswordEl = document.getElementById('guardian_password');
            const guardianPasswordRepeatEl = document.getElementById('guardian_password_confirmation');

            isValid = true; // suponemos que es válido a menos que un campo demuestre lo contrario

            // Validar guardianEmail
            if (guardianEmailEl.value.trim()) {
                guardianEmailEl.classList.remove('input-invalid');
            } else {
                guardianEmailEl.classList.add('input-invalid');
                isValid = false;
            }

            // Validar guardianPassword
            if (guardianPasswordEl.value.trim()) {
                guardianPasswordEl.classList.remove('input-invalid');
            } else {
                guardianPasswordEl.classList.add('input-invalid');
                isValid = false;
            }

            // Validar guardianPasswordRepeat
            if (guardianPasswordRepeatEl.value.trim()) {
                guardianPasswordRepeatEl.classList.remove('input-invalid');
            } else {
                guardianPasswordRepeatEl.classList.add('input-invalid');
                isValid = false;
            }

            // Asegurarse de que las contraseñas coinciden
            if (guardianPasswordEl.value !== guardianPasswordRepeatEl.value) {
                guardianPasswordEl.classList.add('input-invalid');
                guardianPasswordRepeatEl.classList.add('input-invalid');
                isValid = false;
            }

            return isValid;

        case 11:
            // Valida los inputs de Estudiante datos finales
            const studentEmailEl = document.getElementById('student_email');
            const studentPasswordEl = document.getElementById('student_password');
            const studentPasswordRepeatEl = document.getElementById('student_password_confirmation');

            isValid = true; // suponemos que es válido a menos que un campo demuestre lo contrario

            // Validar studentEmail
            if (studentEmailEl.value.trim()) {
                studentEmailEl.classList.remove('input-invalid');
            } else {
                studentEmailEl.classList.add('input-invalid');
                isValid = false;
            }

            // Validar studentPassword
            if (studentPasswordEl.value.trim()) {
                studentPasswordEl.classList.remove('input-invalid');
            } else {
                studentPasswordEl.classList.add('input-invalid');
                isValid = false;
            }

            // Validar studentPasswordRepeat
            if (studentPasswordRepeatEl.value.trim()) {
                studentPasswordRepeatEl.classList.remove('input-invalid');
            } else {
                studentPasswordRepeatEl.classList.add('input-invalid');
                isValid = false;
            }

            // Asegurarse de que las contraseñas coinciden
            if (studentPasswordEl.value !== studentPasswordRepeatEl.value) {
                studentPasswordEl.classList.add('input-invalid');
                studentPasswordRepeatEl.classList.add('input-invalid');
                isValid = false;
            }

            return isValid;

        default:
            return true;
    }
};


const moveToPreviousStep = () => {
    if (stepsHistory.value.length > 0) {
        const lastStep = stepsHistory.value.pop();
        currentStep.value = lastStep;
    }
};

/*
* Logic to control the calendar
*/
const registerType = ref("minor");
const calendarActivityName = ref('Colegio');
const setMinorEnrollment = () => {
    registerType.value = "minor";
    calendarActivityName.value = "Colegio";
};
const setAdultEnrollment = () => {
    registerType.value = "over18";
    calendarActivityName.value = "";
};
const selectedDays = ref({
  LUN: false,
  MAR: false,
  MIE: false,
  JUE: false,
  VIE: false,
  SAB: false,
});
const startTime = ref('');
const endTime = ref('');
const days = ['LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB'];
const hours = [];
for (let i = 8; i < 24; i++) {
  for (let j = 0; j < 60; j += 15) {
    const hour = i.toString().padStart(2, '0');
    const minute = j.toString().padStart(2, '0');
    hours.push(`${hour}:${minute}`);
  }
}
const events = ref({
  LUN: [],
  MAR: [],
  MIE: [],
  JUE: [],
  VIE: [],
  SAB: [],
});

const saveEvents = () => {
    for (const day of days) {
        events.value[day] = [];
    }

    // REVIEW: Como hacer esto... se le dan para atrás en el calendario se pierden los eventos? No se pierden?...
    for (const day of days) {
        if (selectedDays.value[day]) {
            events.value[day].push({
                name: calendarActivityName.value,
                start: startTime.value,
                end: endTime.value,
            });
        }
    }
};

const removeBackground = () => {
    const formContainer = document.querySelector('.form-container-custom');
    formContainer.classList.remove('form-container-custom');
    formContainer.classList.add('form-container-custom-calendarview');
};

const addBackground = () => {
    const formContainer = document.querySelector('.form-container-custom-calendarview');
    formContainer.classList.remove('form-container-custom-calendarview');
    formContainer.classList.add('form-container-custom');
};

/*
* Logic to control the form data and submit it.
*/
const additionalRepresentativesEmails = ref([""]);
const emailInput = ref([""]);
const emailMatches = ref([false]);

const isValidEmail = (email) => {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regex.test(email);
};

const checkEmailValidity = (index) => {
    if (emailInput.value[index] === additionalRepresentativesEmails.value[index] && emailInput.value[index] !== "" ) {
        emailMatches.value[index] = true;
    } else {
        emailMatches.value[index] = false;
    }
};

const addNewEmailField = () => {
    additionalRepresentativesEmails.value.push("");
    emailInput.value.push("");
    emailMatches.value.push(false);
};

const addEmailToRepresentatives = (index) => {
    additionalRepresentativesEmails.value[index] = emailInput.value[index];
    emailMatches.value[index] = true;
};

const removeEmail = (index) => {
    additionalRepresentativesEmails.value.splice(index, 1);
    emailInput.value.splice(index, 1);
    emailMatches.value.splice(index, 1);
};

const form = useForm({
    guardian_name: '',
    guardian_surname: '',
    guardian_birth_date: '',
    guardian_dni: '',
    guardian_phone: '',
    guardian_gender: 0,
    guardian_email: '',
    guardian_password: '',
    guardian_password_confirmation: '',
    guardian_type: 0,

    guardian_others: [],

    student_name: '',
    student_surname: '',
    student_birth_date: '',
    student_dni: '',
    student_phone: '',
    student_gender: 0,
    student_email: '',
    student_password: '',
    student_password_confirmation: '',

    student_experience_speciality: 0,
    student_experience_years: 0,

    student_speciality_option1: 0,
    student_speciality_option2: 0,
    student_speciality_option3: 0,

    student_availability: [],
});

const filteredSpecialitiesForOption1 = computed(() => {
    return props.specialities.filter(speciality => 
        speciality.id !== form.student_speciality_option2 &&
        speciality.id !== form.student_speciality_option3
    );
});

const filteredSpecialitiesForOption2 = computed(() => {
    return props.specialities.filter(speciality => 
        speciality.id !== form.student_speciality_option1 &&
        speciality.id !== form.student_speciality_option3
    );
});

const filteredSpecialitiesForOption3 = computed(() => {
    return props.specialities.filter(speciality => 
        speciality.id !== form.student_speciality_option1 &&
        speciality.id !== form.student_speciality_option2
    );
});

const submit = () => {
    form.guardian_others = additionalRepresentativesEmails.value;
    form.student_availability = events.value;

    if (form.student_speciality_option1 === 0) {
        form.student_speciality_option1 = null;
    }

    if (form.student_speciality_option2 === 0) {
        form.student_speciality_option2 = null;
    }

    if (form.student_speciality_option3 === 0) {
        form.student_speciality_option3 = null;
    }

    if (form.student_experience_speciality === 0) {
        form.student_experience_speciality = null;
    }

    if(form.guardian_type == 1) {
        form.guardian_type = "guardian"
    } else {
        form.guardian_type = "father"
    }

    if(form.guardian_gender == 0) {
        form.guardian_gender = null;
    }

    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <EnrollmentLayout>
        <Head title="Matriculación" />

        <!-- <div class="min-h-screen md:flex-row md:justify-center items-center pt-6 sm:pt-0">

        </div> -->

        <div class="flex flex-row justify-center items-center pt-6">

            <div :class="{ 'current-step': true }" v-if="currentStep != 13">
                <div>{{ steps[currentStep - 1].step }} - {{ steps[6].step }} </div>
                <div>{{ steps[currentStep - 1].title }}</div>
                <div v-if="steps[currentStep - 1].subtitle">{{ steps[currentStep - 1].subtitle }}</div>
                <div>{{ steps[currentStep - 1].description }}</div>
            </div>

            <div class="px-6 py-4 form-container-custom overflow-hidden shadow-md">
                <form @submit.prevent="submit">

                    <!-- Paso 1. -->
                    <div v-if="currentStep === 1">
                        <div>¿A quién quieres inscribir a través de este proceso de matriculación?</div>
                        <div class="items-center">
                            <!-- Este lleva al paso 2 -->
                            <ButtonGeneric class="d-block" type="button" @click="moveToStep(2); setAdultEnrollment();">
                                A mi mismo
                            </ButtonGeneric>

                            <span>Si eres mayor de 18 años.</span>
                        </div>
                        <div>
                            <!-- Este lleva al paso especial, case 8 -->
                            <ButtonGeneric class="d-block" type="button" @click="moveToStep(8); setMinorEnrollment();">
                                A un menor
                            </ButtonGeneric>

                            <span>Si eres su representante legal.</span>
                        </div>
                    </div>

                    <!-- Case 8 - Paso 2. Representante legal. -->
                    <div v-if="currentStep === 8"> 
                        <div>
                            <InputLabel for="guardian_name" value="Nombre*" />

                            <TextInput
                                id="guardian_name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                v-model="form.guardian_name"
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.guardian_name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="guardian_surname" value="Apellido*" />

                            <TextInput
                                id="guardian_surname"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.guardian_surname"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.guardian_surname" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="guardian_birth_date" value="Fecha de nacimiento*" />

                            <input 
                                id="guardian_birth_date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.guardian_birth_date"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.guardian_birth_date" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="guardian_dni" value="DNI*" />

                            <TextInput
                                id="guardian_dni"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.guardian_dni"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.guardian_dni" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="guardian_phone" value="Teléfono*" />

                            <TextInput
                                id="guardian_phone"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.guardian_phone"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.guardian_phone" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="guardian_gender" value="Género*" />

                            <select v-model="form.guardian_gender" id="guardian_gender">
                                <option value="0" disabled>Por favor selecciona uno</option>
                                <option value="m" > Masculino </option>
                                <option value="w" > Femenino </option>
                                <option value="o" > Prefiero no decirlo </option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <SecondaryButton class="d-block" type="button" @click="moveToStep(9)">
                                Añadir otro responsable legal
                            </SecondaryButton>
                        </div>

                        <div class="mt-4">
                            <ButtonGeneric class="d-block" type="button" @click="validaAndMoveToStep(8, 10)">
                                Siguiente
                            </ButtonGeneric>

                            <DangerButton class="d-block" type="button" @click="moveToPreviousStep">
                                Volver
                            </DangerButton>
                        </div>

                    </div>

                    <!-- Case 9 - Paso 2. Representante legal extra. -->
                    <div v-if="currentStep === 9">
                        <div v-for="(email, index) in additionalRepresentativesEmails" :key="index">
                            <div>
                                <InputLabel :for="'guardian_email_' + index" value="Correo del Representante Legal Adicional*" />

                                <TextInput
                                    :id="'guardian_email_' + index"
                                    type="email"
                                    v-model="emailInput[index]"
                                    @input="checkEmailValidity(index)"
                                    :class="{ 'green-border': emailMatches[index] }"
                                    required
                                />

                                <button v-if="isValidEmail(emailInput[index]) && !emailMatches[index]" @click="addEmailToRepresentatives(index)" type="button">+</button>
                                <button v-if="emailMatches[index]" @click="removeEmail(index)" type="button">🗑️</button>
                            </div>
                        </div>
                        <ButtonGeneric class="d-block" type="button" @click="addNewEmailField">
                            Añadir otro responsable legal
                        </ButtonGeneric>

                        <DangerButton class="d-block" type="button" @click="moveToPreviousStep">
                            Volver
                        </DangerButton>
                    </div>

                    <!-- Case 11 - Paso 2. Representante legal datos finales. -->
                    <div v-if="currentStep === 10"> 
                        <div>
                            <InputLabel for="guardian_email" value="Correo*" />

                            <TextInput
                                id="guardian_email"
                                type="email"
                                class="mt-1 block w-full"
                                autofocus
                                v-model="form.guardian_email"
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="form.errors.guardian_email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="guardian_password" value="Contraseña*" />

                            <TextInput
                                id="guardian_password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.guardian_password"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.guardian_password" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="guardian_password_confirmation" value="Repetir Contraseña*" />

                            <TextInput
                                id="guardian_password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.guardian_password_confirmation"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.guardian_password_confirmation" />
                        </div>

                        <div class="mt-4">
                            <label class="form-label">¿Quién eres?</label>

                            <div class="form-check form-switch d-flex flex-column align-items-vertical">
                                <div class="d-flex flex-row gap-3">
                                    <label class="form-check-label" for="guardian_type" value="0">Madre/Padre</label>
                                    <label class="form-check-label" for="guardian_type" value="1">Responsable</label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" role="switch" id="guardian_type" v-model="form.guardian_type">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <ButtonGeneric class="d-block" type="button" @click="validaAndMoveToStep(10, 2)">
                                Siguiente
                            </ButtonGeneric>

                            <DangerButton class="d-block" type="button" @click="moveToPreviousStep">
                                Volver
                            </DangerButton>
                        </div>

                    </div>


                    <!-- Paso 2 Estudiante. -->
                    <div v-if="currentStep === 2"> 
                        <div>
                            <InputLabel for="student_name" value="Nombre*" />

                            <TextInput
                                id="student_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.student_name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.student_name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="student_surname" value="Apellido*" />

                            <TextInput
                                id="student_surname"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.student_surname"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.student_surname" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="student_birth_date" value="Fecha de nacimiento*" />

                            <input 
                                id="student_birth_date"
                                type="date"
                                class="mt-1 block"
                                v-model="form.student_birth_date"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.student_birth_date" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="student_dni" value="DNI*" />

                            <TextInput
                                id="student_dni"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.student_dni"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.student_dni" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="student_gender" value="Género*" />

                            <select v-model="form.student_gender" id="student_gender">
                                <option value="0" disabled>Por favor selecciona uno</option>
                                <option value="m" > Masculino </option>
                                <option value="w" > Femenino </option>
                                <option value="o" > Prefiero no decirlo </option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <ButtonGeneric class="d-block" type="button" @click="validaAndMoveToStep(2, 11)">
                                Siguiente
                            </ButtonGeneric>
                            
                            <DangerButton class="d-block" type="button" @click="moveToPreviousStep">
                                Volver
                            </DangerButton>
                        </div>

                    </div>

                    <!-- Case 12 - Paso 2. Estudiante datos finales. -->
                    <div v-if="currentStep === 11"> 
                        <div>
                            <InputLabel for="student_email" value="Correo*" />

                            <TextInput
                                id="student_email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.student_email"
                                autofocus
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="form.errors.student_email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="student_phone" value="Teléfono (opcional)" />

                            <TextInput
                                id="student_phone"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.student_phone"
                            />

                            <InputError class="mt-2" :message="form.errors.student_phone" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="student_password" value="Contraseña*" />

                            <TextInput
                                id="student_password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.student_password"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.student_password" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="student_password_confirmation" value="Repetir Contraseña*" />

                            <TextInput
                                id="student_password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.student_password_confirmation"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.student_password_confirmation" />
                        </div>

                        <div class="mt-4">
                            <ButtonGeneric class="d-block" type="button" @click="validaAndMoveToStep(11, 3)">
                                Siguiente
                            </ButtonGeneric>

                            <DangerButton class="d-block" type="button" @click="moveToPreviousStep">
                                Volver
                            </DangerButton>
                        </div>

                    </div>

                    <!-- Paso 3 -->
                    <div v-if="currentStep === 3">

                        <div>
                            <div>¿A quién quieres inscribir a través de este proceso de matriculación?</div>
                            
                            <ButtonGeneric class="d-block" type="button" @click="moveToStep(12)">
                                Si, tengo estudios musicales
                            </ButtonGeneric>

                            
                            <ButtonGeneric class="d-block" type="button" @click="moveToStep(4)">
                                No, es mi primera vez
                            </ButtonGeneric>

                        </div>

                        <div class="mt-4">
                            <DangerButton class="d-block" type="button" @click="moveToPreviousStep">
                                Volver
                            </DangerButton>
                        </div>

                    </div>

                    <!-- Case 13 - Paso 3. El alumno tiene experiencia -->
                    <div v-if="currentStep === 12">
                        <div>
                            <InputLabel for="student_experience_speciality" value="Instrumento" />

                            <select v-model="form.student_experience_speciality">
                                <option value="0" disabled>Elije un instrumento</option>
                                <option v-for="speciality in specialities" :key="speciality.id" :value="speciality.id" > {{ speciality.name }} </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.student_experience_speciality" />
                        </div>

                        <div>
                            <InputLabel for="student_experience_years" value="Tiempo de experiencia" />

                            <div class="slider-container">
                                <input type="range" min="0" max="4" v-model="form.student_experience_years" class="slider">
                                <div class="slider-labels">
                                    <span>0-6 meses</span>
                                    <span>1 año</span>
                                    <span>2 años</span>
                                    <span>3 años</span>
                                    <span>3+ años</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <ButtonGeneric class="d-block" type="button" @click="validaAndMoveToStep(12, 4)">
                                Siguiente
                            </ButtonGeneric>

                            <DangerButton class="d-block" type="button" @click="moveToPreviousStep">
                                Volver
                            </DangerButton>
                        </div>

                        </div>

                    <!-- Paso 4 -->
                    <div v-if="currentStep === 4">
                        <div>
                            <InputLabel for="student_speciality_option1" value="1º Opción" />

                            <select v-model="form.student_speciality_option1">
                                <option value="0" disabled>Elije un instrumento</option>
                                <option v-for="speciality in filteredSpecialitiesForOption1" :key="speciality.id" :value="speciality.id" > {{ speciality.name }} </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.student_speciality_option1" />
                        </div>

                        <div>
                            <InputLabel for="student_speciality_option2" value="2º Opción" />

                            <select v-model="form.student_speciality_option2">
                                <option value="0" disabled>Elije un instrumento</option>
                                <option v-for="speciality in filteredSpecialitiesForOption2" :key="speciality.id" :value="speciality.id" > {{ speciality.name }} </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.student_speciality_option2" />
                        </div>

                        <div>
                            <InputLabel for="student_speciality_option3" value="3º Opción" />

                            <select v-model="form.student_speciality_option3">
                                <option value="0" disabled>Elije un instrumento</option>
                                <option v-for="speciality in filteredSpecialitiesForOption3" :key="speciality.id" :value="speciality.id" > {{ speciality.name }} </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.student_speciality_option3" />
                        </div>

                        <div class="mt-4">
                            <ButtonGeneric class="d-block" type="button" @click="moveToStep(5)">
                                Siguiente
                            </ButtonGeneric>
                            
                            <DangerButton class="d-block" type="button" @click="moveToPreviousStep">
                                Volver
                            </DangerButton>
                        </div>

                    </div>

                    <!-- Paso 5 -->
                    <div v-if="currentStep === 5">

                        <div>
                            <InputLabel value="Nombre" />
                            <TextInput
                                type="text"
                                class="mt-1 block w-full"
                                required
                                v-model="calendarActivityName"
                            />
                        </div>

                        <div class="d-flex flex-column mt-2">
                            <InputLabel value="Seleccione los días" />

                            <div v-for="day in days" :key="day">
                                <input type="checkbox" v-model="selectedDays[day]" />
                                {{ day }}
                            </div>


                        </div>

                        <div class="d-flex flex-column  mt-2">
                            <InputLabel value="Horario" />

                            <div clas="d-flex flex-row justify-content-around">
                                <div>
                                    <input type="time" v-model="startTime" min="08:00:00" max="00:00:00">
                                </div>

                                <div>
                                    <input type="time" v-model="endTime" min="08:00:00" max="00:00:00">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <ButtonGeneric class="d-block" type="button" @click="moveToStep(13); removeBackground(); saveEvents();">
                                Siguiente
                            </ButtonGeneric>
                            
                            <DangerButton class="d-block" type="button" @click="moveToPreviousStep">
                                Volver
                            </DangerButton>
                        </div>

                    </div>

                    <div v-if="currentStep === 13">

                        <Calendar :events="events" :days="days" :hours="hours" /> 

                        <div class="mt-4">
                            <ButtonGeneric class="d-block" type="button" @click="moveToStep(6)">
                                &gt;
                            </ButtonGeneric>
                            
                            <DangerButton class="d-block mt-1" type="button" @click="moveToPreviousStep(); addBackground();">
                                &lt;
                            </DangerButton>
                        </div>
                    </div>

                    <!-- Paso 6 -->
                    <div v-if="currentStep === 6"> 
                        <div class="flex items-center justify-end mt-4">
                            <ButtonGeneric class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Confirmar Datos
                            </ButtonGeneric>

                            <ButtonGeneric class="d-block" type="button" @click="moveToPreviousStep">
                                Modificar
                            </ButtonGeneric>
                        </div>
                        <div v-if="$page.props.flash.success" class="text-success mt-2 text-center">{{ $page.props.flash.success }}</div>
                        <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0" class="text-danger mt-2 text-center">
                            <ul>
                                <li v-for="(error, field) in $page.props.errors">{{ error }}</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </EnrollmentLayout>
</template>

<style scoped>

.form-container-custom {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    border-radius: 3.125rem;
    min-width: 33.5vw;
    min-height: 80vh;
    border: 1px solid #3C7FF8;
    background: linear-gradient(180deg, #FFF 0%, #B5CFFD 100%);
    margin-right: 4vw !important;
    margin-left: 6vw !important;
    box-shadow:0rem 0rem 1rem 0.5rem #00000015;
}

.form-container-custom-calendarview {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    min-width: 33.5vw;
    min-height: 80vh;
    margin-right: 4vw !important;
    margin-left: 6vw !important;
    box-shadow: none;
}

.current-step {
    font-weight: bold;
    background-color: #B5CFFD;
}

.green-border {
    border: 2px solid green;
}

.input-invalid {
    border: 1px solid red;
    background-color: #ffe6e6; /* Un ligero color rojo de fondo */
}

/* Estilo para la barra horizontal */

.slider-container {
    width: 100%;
    position: relative;
}

.slider {
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 10px;
    border-radius: 5px;
    background: #d3d3d3;
    outline: none;
    transition: opacity 0.2s;
}

.slider:hover {
    opacity: 0.7;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #007BFF; /* Azul */
    cursor: pointer;
}

.slider::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #007BFF; /* Azul */
    cursor: pointer;
}

.slider-labels {
    display: flex;
    justify-content: space-between;
    position: absolute;
    width: 100%;
    padding: 10px 0;
    top: 30px;
    pointer-events: none;
}

</style>