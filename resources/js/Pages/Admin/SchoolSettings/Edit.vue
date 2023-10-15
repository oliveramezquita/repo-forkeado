<script setup>
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ButtonGeneric from '@/Components/ButtonGeneric.vue';
import { Head, useForm } from '@inertiajs/vue3';

import { appType } from '@/utils/inertiaUtils';

const customroute = 'school.settings.edit';

const currentTab = ref('General');

const editing = ref(false);

const currentYear = ref(new Date().getFullYear());

const props = defineProps ({
    settings: {
        type: Object,
        default: () => [],
    },
});

const form = useForm({
    school_name: props.settings.school_name || '',
    school_name_short: props.settings.school_name_short || '',
    school_address: props.settings.school_address || '',
    school_phone: props.settings.school_phone || '',
    school_cif: props.settings.school_cif || '',
    school_email: props.settings.school_email || '',
    school_web: props.settings.school_web || '',
    school_logo: props.settings.school_logo || '',


    subjects_to_pass: props.settings.subjects_to_pass || 0,
    previous_subject_passed: props.settings.previous_subject_passed == 1 ? true : false,


    max_loans: props.settings.max_loans || 0,


    max_annual_instalments_fees: props.settings.max_annual_instalments_fees || 0,

    
    current_enrollment: props.settings.current_enrollment,
    end_current_enrollment: props.settings.end_current_enrollment,
    next_enrollment: props.settings.next_enrollment,
    end_next_enrollment: props.settings.end_next_enrollment,
    starting_time: props.settings.starting_time || currentYear.value + '-09-01',
    ending_time: props.settings.ending_time || (currentYear.value+1) + '-07-31',
});

const submit = () => {
    form.patch(route('school.settings.update'), {
        preserveScroll: true,
        onSuccess: () => {
            editing.value = false;
        },
    });
}

</script>

<template>

    <Head title="Ajustes del Centro" />

    <AuthenticatedLayout :croute="customroute">

        <div style="display: flex; justify-content: center; align-items: center;">
            <h1 style="color: #2B5DB6; font-size: 1.8rem; font-weight: 600; margin-bottom: 2.5rem;">Configuración del Centro</h1>
        </div>

        <div class="tabs-container">
            <button 
                v-for="tab in ['General', 'Organigrama', 'Académico', 'Económico', 'Legal', 'Otros']" 
                :key="tab" 
                @click="currentTab = tab" 
                :class="{ 'tab-button-active': currentTab === tab }"
                class="tab-button"
            >
                {{ tab }}
            </button>
        </div>

        <form @submit.prevent="submit">

            <div v-if="currentTab === 'General'" class="general-tab-content">

                <!-- Boton de editar -->
                <div v-if="!editing" class="edit-icon">
                    <i class="fa-regular fa-gear" @click="editing = !editing"></i>
                </div>

                <!--Columna 1-->
                <div class="image-column">
                    <img src="https://via.placeholder.com/300x300" alt="Logo de la escuela">
                </div>

                <!--Columna 2-->
                <div class="data-column">
                    <div class="mt-3">
                        <InputLabel for="school_name" value="Nombre del Centro *" />

                        <div v-if="!editing">
                            {{ form.school_name }}
                        </div>

                        <div v-else>

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
                    </div>
                        
                    <div class="mt-3">
                        <InputLabel for="school_name_short" value="Nombre Corto del Centro" />

                        <div v-if="!editing">
                            {{ form.school_name_short }}
                        </div>

                        <div v-else>

                            <TextInput
                                id="school_name_short"
                                type="text"
                                class="mt-1 block"
                                v-model="form.school_name_short"
                            />

                            <InputError class="mt-2" :message="form.errors.school_name_short" />
                        </div>
                    </div>
                
                    <div class="mt-3">
                        <InputLabel for="school_address" value="Dirección del Centro *" />

                        <div v-if="!editing">
                            {{ form.school_address }}
                        </div>

                        <div v-else>
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
                            placeholder="968000000"
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
                <hr>


            </div>


            <div v-if="currentTab === 'Organigrama'" class="organigrama-tab-content">  

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
                        max="100"
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
                        :min="`${currentYear}-01-01`"
                        :max="`${currentYear}-12-31`"
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
                    <InputLabel for="end_next_enrollment" value="Fecha fin del próximo periodo de matriculación." />
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
            <div class="flex items-center justify-center mt-5" v-if="editing">
                <ButtonGeneric :disabled="form.processing">Guardar</ButtonGeneric>
            </div>

            <div v-if="$page.props.flash.success" class="text-success mt-2 text-center">{{ $page.props.flash.success }}</div>
            <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0" class="text-danger mt-2 text-center">
                <ul>
                    <li v-for="(error, field) in $page.props.errors">{{ error }}</li>
                </ul>
            </div>

        </form>
    </AuthenticatedLayout>
</template>

<style scoped>

.tabs-container {
    border-radius: 3rem; 
    padding: 0.2rem 0.3rem; /* Relleno alrededor de las tabs */
    height: 3.5rem;
    background-color: #ECECEC;
    display: flex;
}

.tab-button {
    flex: 1; /* Ajusta el ancho de las tabs */
    transition: color 0.3s, border-color 0.3s;
    color: #2B5DB6;  /* Color por defecto (puedes ajustar) */
    font-weight: 400;
    font-size: 1.2rem;
    transition: color 0.3s ease-out;
}

.tab-button:hover {
    text-decoration: none;
    color: #3C7FF8;  /* Color de hover (puedes ajustar) */
}

.tab-button-active {
    color: white;  /* Color del texto cuando el tab está activo (puedes ajustar) */
    border-radius: 3rem; /* Redondeo de bordes para un toque más suave */
    background: #3C7FF8;
    font-weight: 600;
    box-shadow: 0px 0.1rem 0.6rem rgba(0, 0, 0, 0.1);
}

.tab-button-active:hover {
    color: white;  /* Color del texto cuando el tab está activo (puedes ajustar) */
    background: #3C7FF8;
}


.general-tab-content {
    border-radius: 4rem; 
    box-shadow: 0 0rem 1rem rgba(0, 0, 0, 0.15); 
    padding: 2rem; 
    background-color: #ffffff; 
    display: flex; 
    gap: 2rem; 
    margin-top: 2rem;
    position: relative;
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

.edit-icon {
    position: absolute;  /* Para posicionar el ícono en relación al contenedor padre con position: relative */
    right: 0;  
    top: 0;
    cursor: pointer;
    z-index: 100;  /* Asegura que esté encima de otros elementos dentro del contenedor */
    color:#2B5DB6
}

.edit-icon:hover {
    color: #3C7FF8;
}


</style>