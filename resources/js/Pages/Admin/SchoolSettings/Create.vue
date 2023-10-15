<script setup>
import { ref, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InitialSetupLayout from '@/Layouts/InitialSetupLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

import { permissions, appType } from '@/utils/inertiaUtils';

const currentStep = ref(1);

const currentYear = ref(new Date().getFullYear());

const form = useForm({
    school_name: '',
    school_name_short: '',
    school_address: '',
    school_phone: '',
    school_cif: '',
    school_email: '',
    school_web: '',
    school_logo: '',


    subjects_to_pass: 0,
    previous_subject_passed: false,


    max_loans: 0,


    max_annual_instalments_fees: 0,

    
    current_enrollment: '',
    end_current_enrollment: '',
    starting_time: currentYear.value + '-09-01',
    next_enrollment: '',
    end_next_enrollment: '',
    ending_time: (currentYear.value+1) + '-07-31',
});

let isValid = false;
const checkCurrentPage = () => {
    switch (currentStep.value) {
        case 1:
            // Valida los inputs del centro
            const schoolNameEl = document.getElementById('school_name');
            const schoolAddressEl = document.getElementById('school_address');
            const schoolPhoneEl = document.getElementById('school_phone');
            const schoolCifEl = document.getElementById('school_cif');
            const SchoolEmailEl = document.getElementById('school_email');

            isValid = true; // suponemos que es válido a menos que un campo demuestre lo contrario

            if (schoolNameEl.value.trim()) {
                schoolNameEl.classList.remove('input-invalid');
            } else {
                schoolNameEl.classList.add('input-invalid');
                isValid = false;
            }

            if (schoolAddressEl.value.trim()) {
                schoolAddressEl.classList.remove('input-invalid');
            } else {
                schoolAddressEl.classList.add('input-invalid');
                isValid = false;
            }

            if (schoolPhoneEl.value) {
                schoolPhoneEl.classList.remove('input-invalid');
            } else {
                schoolPhoneEl.classList.add('input-invalid');
                isValid = false;
            }

            if (schoolCifEl.value.trim()) {
                schoolCifEl.classList.remove('input-invalid');
            } else {
                schoolCifEl.classList.add('input-invalid');
                isValid = false;
            }
            
            if (SchoolEmailEl.value.trim()) {
                SchoolEmailEl.classList.remove('input-invalid');
            } else {
                SchoolEmailEl.classList.add('input-invalid');
                isValid = false;
            }

            if(isValid)
                currentStep.value++;

            return;
        
        case 2:
            // Valida los inputs del organigrama
            const currentEnrollmentEl = document.getElementById('current_enrollment');
            const startingTimeEl = document.getElementById('starting_time');
            const endingTimeEl = document.getElementById('ending_time');


            isValid = true; // suponemos que es válido a menos que un campo demuestre lo contrario

            if (currentEnrollmentEl.value) {
                currentEnrollmentEl.classList.remove('input-invalid');
            } else {
                currentEnrollmentEl.classList.add('input-invalid');
                isValid = false;
            }

            if(appType.value == 'cons') {
                const endingCurrentEnrollmentEl = document.getElementById('end_current_enrollment');
                if (endingCurrentEnrollmentEl.value) {
                    endingCurrentEnrollmentEl.classList.remove('input-invalid');
                } else {
                    endingCurrentEnrollmentEl.classList.add('input-invalid');
                    isValid = false;
                }
            }

            if (startingTimeEl.value) {
                startingTimeEl.classList.remove('input-invalid');
            } else {
                startingTimeEl.classList.add('input-invalid');
                isValid = false;
            }

            if (endingTimeEl.value) {
                endingTimeEl.classList.remove('input-invalid');
            } else {
                endingTimeEl.classList.add('input-invalid');
                isValid = false;
            }

            if(isValid)
                currentStep.value++;

            return;

        case 3:
            currentStep.value++;
            return;

        case 4:
            currentStep.value++;
            return;

        case 5:
            currentStep.value++;
            return;
            
    }
}

const submit = () => {
    form.post(route('school.settings.store'));
}

</script>

<template>

    <Head title="Ajustes del Centro" />

    <InitialSetupLayout>

        <div v-if="!permissions.includes('school.settings.store')" class="alert alert-danger mt-4 text-center" role="alert">
            ¡La configuración está vacía y es necesaria para que funcione Amadeus! 
            <br/> 
            Por favor, pídele al director que inicie sesión y la complete.
            <br/> 
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="btn button-danger">
                <i title="Salir" class="fa-light fa-arrow-right-from-bracket icon-size"></i>
            </Link>
        </div>
        <div v-else>

            <form @submit.prevent="submit">

                <div class="steps-nav">
                    <div :class="['step-item', { active: currentStep === 1 }]" data-step="1">General</div>
                    <div :class="['step-item', { active: currentStep === 2 }]" data-step="2">Organigrama</div>
                    <div :class="['step-item', { active: currentStep === 3 }]" data-step="3">Académico</div>
                    <div :class="['step-item', { active: currentStep === 4 }]" data-step="4">Económico</div>
                    <div :class="['step-item', { active: currentStep === 5 }]" data-step="5">Legal</div>
                    <div :class="['step-item', { active: currentStep === 6 }]" data-step="6">Otros</div>
                </div>

                <div class="steps-content mt-4">
                    <div :class="['step-content', { activeRow: currentStep === 1 }]" id="step1">

                        <!--Columna 1-->
                        <div class="image-column">
                            <img src="https://via.placeholder.com/300x300" alt="Logo de la escuela">
                        </div>

                        <!--Columna 2-->
                        <div class="data-column">
                            <div class="mt-3">
                                <InputLabel for="school_name" value="Nombre del Centro *" />

                                <TextInput
                                    id="school_name"
                                    type="text"
                                    class="mt-1 block"
                                    v-model="form.school_name"
                                    required
                                    autofocus
                                />

                                <InputError class="mt-2" :message="form.errors.school_name" />
                            </div>
                                
                            <div class="mt-3">
                                <InputLabel for="school_name_short" value="Nombre Corto del Centro" />

                                <TextInput
                                    id="school_name_short"
                                    type="text"
                                    class="mt-1 block"
                                    v-model="form.school_name_short"
                                />

                                <InputError class="mt-2" :message="form.errors.school_name_short" />
                            </div>
                        
                            <div class="mt-3">
                                <InputLabel for="school_address" value="Dirección del Centro *" />

                                <TextInput
                                    id="school_address"
                                    type="text"
                                    class="mt-1 block"
                                    v-model="form.school_address"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.school_address" />
                            </div>
                        </div>

                        <!-- Columna 3: Datos del centro (Parte 2) -->
                        <div class="data-column">

                            <div class="mt-3">
                                <InputLabel for="school_phone" value="Teléfono *" />

                                <TextInput
                                    id="school_phone"
                                    type="tel"
                                    class="mt-1 block"
                                    v-model="form.school_phone"
                                    required
                                    pattern="[0-9]{9}"
                                />

                                <InputError class="mt-2" :message="form.errors.school_phone" />
                            </div>
                            
                            <div class="mt-3">
                                <InputLabel for="school_cif" value="CIF *" />

                                <TextInput
                                    id="school_cif"
                                    type="text"
                                    class="mt-1 block"
                                    v-model="form.school_cif"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.school_cif" />
                            </div>
                            
                            <div class="mt-3">
                                <InputLabel for="school_email" value="Correo Electrónico *" />

                                <TextInput
                                    id="school_email"
                                    type="email"
                                    class="mt-1 block"
                                    v-model="form.school_email"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.school_email" />
                            </div>
                            
                            <div class="mt-3">
                                <InputLabel for="school_web" value="Página Web" />

                                <TextInput
                                    id="school_web"
                                    type="url"
                                    class="mt-1 block"
                                    v-model="form.school_web"
                                />

                                <InputError class="mt-2" :message="form.errors.school_web" />
                            </div>
                            
                            <div class="mt-3">
                                <InputLabel for="school_logo" value="Logo de la escuela" />

                                <TextInput
                                    id="school_logo"
                                    type="url"
                                    class="mt-1 block"
                                    v-model="form.school_logo"
                                />

                                <InputError class="mt-2" :message="form.errors.school_logo" />
                            </div>
                        </div>
                    </div>


                    <div :class="['step-content', { activeCol: currentStep === 2 }]" id="step2">  

                        <!-- Schooling -->
                        <div class="mt-3">
                            <InputLabel for="subjects_to_pass" value="Asignaturas mínimas aprobadas para pasar de curso" />

                            <TextInput 
                                id="subjects_to_pass"
                                type="number"
                                class="mt-1 block"
                                v-model="form.subjects_to_pass"
                                min="0"
                                max="99"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.subjects_to_pass" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="previous_subject_passed" value="La asignatura previa debe estar aprobada" />

                            <input 
                                id="previous_subject_passed"
                                type="checkbox"
                                class="mt-1 block"
                                v-model="form.previous_subject_passed"
                            />

                            <InputError class="mt-2" :message="form.errors.previous_subject_passed" />
                        </div>


                        <hr>
                        <!-- Inventory -->
                        <div class="mt-3">
                            <InputLabel for="max_loans" value="Máximo de préstamos permitidos" />

                            <input 
                                id="max_loans"
                                type="number"
                                class="mt-1 block"
                                v-model="form.max_loans"
                                min="0"
                                max="99"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.max_loans" />
                        </div>


                        <hr>
                        <!-- Finances -->
                        <div class="mt-3">
                            <InputLabel for="max_annual_instalments_fees" value="Máximo de aplazamientos permitidos para el cobro anual" />

                            <input 
                                id="max_annual_instalments_fees"
                                type="number"
                                class="mt-1 block"
                                v-model="form.max_annual_instalments_fees"
                                required
                                min="0"
                                max="10"
                            />

                            <InputError class="mt-2" :message="form.errors.max_annual_instalments_fees" />
                        </div>


                        <hr>
                        <!-- Scholar year -->
                        <div class="mt-3">
                            <InputLabel for="current_enrollment" value="Fecha de inicio de matriculación*." />

                            <input 
                                id="current_enrollment"
                                type="date"
                                :min="`${currentYear-1}-01-01`"
                                :max="`${currentYear+1}-12-31`"
                                class="mt-1 block"
                                v-model="form.current_enrollment"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.current_enrollment" />
                        </div>

                        <div v-if="appType == 'cons'">
                            <InputLabel for="end_current_enrollment" value="Fecha fin de matriculación*." />

                            <input 
                                id="end_current_enrollment"
                                type="date"
                                :min="`${currentYear-1}-01-01`"
                                :max="`${currentYear+1}-12-31`"
                                class="mt-1 block"
                                v-model="form.end_current_enrollment"
                            />

                            <InputError class="mt-2" :message="form.errors.end_current_enrollment" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="starting_time" value="Fecha de comienzo de curso*." />

                            <input 
                                id="starting_time"
                                type="date"
                                :min="`${currentYear-1}-01-01`"
                                :max="`${currentYear+1}-12-31`"
                                class="mt-1 block"
                                v-model="form.starting_time"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.starting_time" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="next_enrollment" value="Fecha de matriculación para el próximo curso escolar." />
                            <span class="text-sm text-warning">Puedes dejarla sin rellenar si la desconoces...</span>

                            <input 
                                id="next_enrollment"
                                type="date"
                                :min="`${currentYear}-01-01`"
                                :max="`${currentYear+1}-12-31`"
                                class="mt-1 block"
                                v-model="form.next_enrollment"
                            />

                            <InputError class="mt-2" :message="form.errors.next_enrollment" />
                        </div>

                        <div v-if="appType == 'cons'">
                            <InputLabel for="end_next_enrollment" value="Fecha fin del próximo periodo de matriculación*." />
                            <span class="text-sm text-warning">Puedes dejarla sin rellenar si la desconoces...</span>

                            <input 
                                id="end_next_enrollment"
                                type="date"
                                :min="`${currentYear}-01-01`"
                                :max="`${currentYear+1}-12-31`"
                                class="mt-1 block"
                                v-model="form.end_next_enrollment"
                            />

                            <InputError class="mt-2" :message="form.errors.end_next_enrollment" />
                        </div>
                        
                        <div class="mt-3">
                            <InputLabel for="ending_time" value="Fecha de fin de curso*." />

                            <input 
                                id="ending_time"
                                type="date"
                                :min="`${currentYear + 1}-01-01`"
                                :max="`${currentYear + 1}-12-31`"
                                class="mt-1 block"
                                v-model="form.ending_time"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.ending_time" />
                        </div>

                    </div>


                    <!-- Send form -->
                    <div :class="['step-content', { activeCol: currentStep === 6 }]" id="step6">
                        <ButtonGeneric :disabled="form.processing">Guardar</ButtonGeneric>

                        <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0" class="text-danger mt-2 text-center">
                            <ul>
                                <li v-for="(error, field) in $page.props.errors">{{ error }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-center gap-2">
                    <button type="button" v-if="currentStep!=1" @click="currentStep--" class="prev-btn">&lt;</button>
                    <button type="button" v-if="currentStep!=6" @click="checkCurrentPage()" class="next-btn">&gt;</button>
                </div>
            </form>
        </div>
    </InitialSetupLayout>
</template>

<style scoped>
.icon-size {
    font-size: 1.5rem;
}

.steps-nav {
    border-radius: 3rem; 
    height: 3.5rem;
    background-color: #ffffff;
    border-color: #2b5db6;
    border-width: 0.05rem;
    display: flex;
    justify-content: center;
    
}

.step-item {
    flex: 1; /* Ajusta el ancho de las tabs */
    transition: color 0.3s, border-color 0.3s;
    color: #2B5DB6;  /* Color por defecto (puedes ajustar) */
    font-weight: 400;
    font-size: 1.2rem;
    transition: color 0.3s ease-out;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 10rem;
    
}

.step-item.active {
    color: white;  /* Color del texto cuando el tab está activo (puedes ajustar) */
    border-radius: 3rem; /* Redondeo de bordes para un toque más suave */
    background: #3C7FF8;
    font-weight: 600;
    box-shadow: 0px 0.1rem 0.6rem rgba(0, 0, 0, 0.1);
}

.steps-content {
    padding: 20px;
}

.step-content {
    display: none;

    border-radius: 4rem; 
    box-shadow: 0 0rem 1rem rgba(0, 0, 0, 0.15); 
    padding: 2rem; 
    background-color: #ffffff; 
    gap: 2rem;
}

.step-content.activeRow {
    display: flex;
    flex-direction: row;
}

.step-content.activeCol {
    display: flex;
    flex-direction: column;
}

.next-btn, .prev-btn {
    font-size: 1.3rem;
    padding: 10px 20px;
    background-color: transparent;
    color: #3C7FF8;
    border: 1px solid #3C7FF8;
    border-radius: 30px;
    cursor: pointer;
}

.next-btn:hover, .prev-btn:hover {
    background-color: #3C7FF8;
    color: white;
}

.image-column {
    flex: 1; 
    display: flex;
    align-items: center;
    justify-content: center;
}

.data-column {
    flex: 2; 
}

input {
    display:flex ;
    width: 100% ;
    height: 3.2rem ;
    border-radius: 3rem;
    border: 1px solid #2b5db6 ;
    background-color: #fff  ;
    font-size: 1.3rem   ;
    text-align: center ;
}

.input-invalid {
    border: 1px solid red;
    background-color: #ffe6e6; /* Un ligero color rojo de fondo */
}

</style>