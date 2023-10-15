<?php

namespace Database\Seeders;

use App\Models\Syllabi\SyllabiBP\SyllabiBP;
use Illuminate\Database\Seeder;
use App\Models\Syllabi\SyllabiBP\DegreeBP;
use App\Models\Syllabi\SyllabiBP\CourseBP;
use App\Models\Syllabi\SyllabiBP\SubjectBP;
use App\Models\Syllabi\SyllabiBP\SpecialityBP;

class SyllabisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Crear nuevos grados
        $elemental = DegreeBP::create([
             // El nombre del grado.
            'name' => 'Grado Elemental',

            // Numero de asignaturas máximas que se pueden suspender 
            // para aprobar el curso.
            'max_failed_subjects_to_pass' => 2,

            // Si el grado está activo o no (ponerlo siempre a true).
            'is_active' => true
        ]);

        $profesional = DegreeBP::create([
            'name' => 'Grado Profesional',
            'max_failed_subjects_to_pass' => 3,
            'is_active' => true
        ]);

        $iniciacion = DegreeBP::create([
            'name' => 'Grado Iniciación',
            'max_failed_subjects_to_pass' => 0,
            'is_active' => true
        ]);

        // Crear nuevos cursos
        $preparatorio = CourseBP::create([
            // El número del curso.
            'number' => '0',

            // El numero pero en cadena de texto
            'name' => 'Preparatorio',

            // Si el curso está activo o no (ponerlo siempre a true).
            'is_active' => true
        ]);

        $primero = CourseBP::create([
            'number' => '1',
            'name' => 'Primero',
            'is_active' => true
        ]);

        $segundo = CourseBP::create([
            'number' => '2',
            'name' => 'Segundo',
            'is_active' => true
        ]);

        $tercero = CourseBP::create([
            'number' => '3',
            'name' => 'Tercero',
            'is_active' => true
        ]);

        $cuarto = CourseBP::create([
            'number' => '4',
            'name' => 'Cuarto',
            'is_active' => true
        ]);

        $quinto = CourseBP::create([
            'number' => '5',
            'name' => 'Quinto',
            'is_active' => true
        ]);

        $sexto = CourseBP::create([
            'number' => '6',
            'name' => 'Sexto',
            'is_active' => true
        ]);

        // Crear nuevas asignaturas
        $coro = SubjectBP::create([
            // El departamento al que pertenece la asignatura.
            // En el fichero DepartmentsSeeder, se crean los departamentos.
            // El ID 1 coresponde al primero que se crea.
            // Si se crea otro departamento, el ID será 2, y así sucesivamente.
            'department_id' => 5,

            // Nombre de la asignatura.
            'name' => 'Coro',

            // Horas lectivas de la asignatura
            'school_hours' => '1',

            // Si la asignatura es obligatoria o no.
            'is_mandatory' => true,

            // Precio de la asignatura.
            'price' => '50.00',

            // Si la asignatura es colectiva (grupal) o no.
            'is_collective' => true,

            // Ratio de alumnos por clase.
            'student_ratio' => 20,
        ]);

        $lenguaje_musical = SubjectBP::create([
            'department_id' => 5,
            'name' => 'Lenguaje musical',
            'school_hours' => '1',
            'is_mandatory' => true,
            'price' => '50.00',
            'is_collective' => true,
            'student_ratio' => 12,
        ]);


        $analisis = SubjectBP::create([
            'department_id' => 8,
            'name' => 'Análisis',
            'school_hours' => '2',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => true,
            'student_ratio' => 15,
        ]);

        $armonia = SubjectBP::create([
            'department_id' => 8,
            'name' => 'Armonía',
            'school_hours' => '2',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => true,
            'student_ratio' => 15,
        ]);

        $historia_musica = SubjectBP::create([
            'department_id' => 8,
            'name' => 'Historia de la música',
            'school_hours' => '2',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => true,
            'student_ratio' => 15,
        ]);

        $informatica = SubjectBP::create([
            'department_id' => 8,
            'name' => 'Informática musical',
            'school_hours' => '1',
            'is_mandatory' => false,
            'price' => '90.00',
            'is_collective' => true,
            'student_ratio' => 15,
        ]);

        $banda = SubjectBP::create([
            'department_id' => 6,
            'name' => 'Banda',
            'school_hours' => '1.5',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => true,
            'student_ratio' => 50,
        ]);

        $orquesta = SubjectBP::create([
            'department_id' => 6,
            'name' => 'Orquesta',
            'school_hours' => '1.5',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => true,
            'student_ratio' => 50,
        ]);

        $musica_camara = SubjectBP::create([
            'department_id' => 6,
            'name' => 'Música de cámara',
            'school_hours' => '1',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => true,
            'student_ratio' => 12,
        ]);

        $piano_complementario = SubjectBP::create([
            'department_id' => 7,
            'name' => 'Piano complementario',
            'school_hours' => '0.5',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => false,
            'student_ratio' => 1,
        ]);

        $bajo_continuo = SubjectBP::create([
            'department_id' => 9,
            'name' => 'Bajo continuo',
            'school_hours' => '1',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => true,
            'student_ratio' => 12,
        ]);
        // nueva asignatura: acompañante, 30m de clase con un profesor pianista acompañante para tocar las obras de la clase indivdual
        $acompanante = SubjectBP::create([
            'department_id' => 9,
            'name' => 'Acompañante',
            'school_hours' => '0.5',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => false,
            'student_ratio' => 1,
        ]);
        // nueva asignatura: idiomas aplicados al canto: italiano
        $iac_italiano = SubjectBP::create([
            'department_id' => 10,
            'name' => 'IAC - Italiano',
            'school_hours' => '1',
            'is_mandatory' => true,
            'price' => '90.00',
            'is_collective' => true,
            'student_ratio' => 12,
        ]);

        // Crear nuevas especialidades
        $piano = SpecialityBP::create([
            // El nombre de la especialidad.
            'name' => 'Piano',

            // Si la especialidad está activa o no (ponerlo siempre a true).
            'is_active' => true
        ]);

        // Importante, a la vez que se crean especialidades, se crean asignaturas.
        // Se crean 2 asignaturas, una colectiva y otra individual.
        $piano_i = SubjectBP::create([
            // El nombre de la asignatura que es (nombre_especialidad - Individual).
            'name' => $piano->name . ' - Individual',

            // El ID de la especialidad que hemos creado en la linea anterior 
            // $sp->id
            'speciality_id' => $piano->id,

            // Si la asignatura es colectiva (grupal) o no.
            'is_collective' => false,

            // Ratio de alumnos por clase.
            'student_ratio' => 1,

            // Si la asignatura está activa o no (ponerlo siempre a true).
            'is_active' => true,
        ]);
        $piano_c = SubjectBP::create([
            // El nombre de la asignatura que es (nombre_especialidad - Colectiva).
            'name' => $piano->name . ' - Colectiva',

            // El ID de la especialidad a la cual esta asignatura pertenece
            'speciality_id' => $piano->id,

            // Si la asignatura es colectiva (grupal) o no.
            'is_collective' => true,

            // Ratio de alumnos por clase.
            'student_ratio' => 8,

            // Si la asignatura está activa o no (ponerlo siempre a true).
            'is_active' => true,
        ]);

        $trompeta = SpecialityBP::create([
            'name' => 'Trompeta',
            'is_active' => true
        ]);
        $trompeta_i = SubjectBP::create([
            'name' => $trompeta->name . ' - Individual',
            'speciality_id' => $trompeta->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $trompeta_c = SubjectBP::create([
            'name' => $trompeta->name . ' - Colectiva',
            'speciality_id' => $trompeta->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $violin = SpecialityBP::create([
            'name' => 'Violín',
            'is_active' => true
        ]);
        $violin_i = SubjectBP::create([
            'name' => $violin->name . ' - Individual',
            'speciality_id' => $violin->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $violin_c = SubjectBP::create([
            'name' => $violin->name . ' - Colectiva',
            'speciality_id' => $violin->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $clarinete = SpecialityBP::create([
            'name' => 'Clarinete',
            'is_active' => true
        ]);
        $clarinete_i = SubjectBP::create([
            'name' => $clarinete->name . ' - Individual',
            'speciality_id' => $clarinete->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $clarinete_c = SubjectBP::create([
            'name' => $clarinete->name . ' - Colectiva',
            'speciality_id' => $clarinete->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $oboe = SpecialityBP::create([
            'name' => 'Oboe',
            'is_active' => true
        ]);

        $oboe_i = SubjectBP::create([
            'name' => $oboe->name . ' - Individual',
            'speciality_id' => $oboe->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $oboe_c = SubjectBP::create([
            'name' => $oboe->name . ' - Colectiva',
            'speciality_id' => $oboe->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $flauta = SpecialityBP::create([
            'name' => 'Flauta travesera',
            'is_active' => true
        ]);
        $flauta_i = SubjectBP::create([
            'name' => $flauta->name . ' - Individual',
            'speciality_id' => $flauta->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $flauta_c = SubjectBP::create([
            'name' => $flauta->name . ' - Colectiva',
            'speciality_id' => $flauta->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $saxofon = SpecialityBP::create([
            'name' => 'Saxofón',
            'is_active' => true
        ]);
        $saxofon_i = SubjectBP::create([
            'name' => $saxofon->name . ' - Individual',
            'speciality_id' => $saxofon->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $saxofon_c = SubjectBP::create([
            'name' => $saxofon->name . ' - Colectiva',
            'speciality_id' => $saxofon->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $fagot = SpecialityBP::create([
            'name' => 'Fagot',
            'is_active' => true
        ]);
        $fagot_i = SubjectBP::create([
            'name' => $fagot->name . ' - Individual',
            'speciality_id' => $fagot->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $fagot_c = SubjectBP::create([
            'name' => $fagot->name . ' - Colectiva',
            'speciality_id' => $fagot->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $trompa = SpecialityBP::create([
            'name' => 'Trompa',
            'is_active' => true
        ]);
        $trompa_i = SubjectBP::create([
            'name' => $trompa->name . ' - Individual',
            'speciality_id' => $trompa->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $trompa_c = SubjectBP::create([
            'name' => $trompa->name . ' - Colectiva',
            'speciality_id' => $trompa->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $trombon = SpecialityBP::create([
            'name' => 'Trombón',
            'is_active' => true
        ]);
        $trombon_i = SubjectBP::create([
            'name' => $trombon->name . ' - Individual',
            'speciality_id' => $trombon->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $trombon_c = SubjectBP::create([
            'name' => $trombon->name . ' - Colectiva',
            'speciality_id' => $trombon->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $tuba = SpecialityBP::create([
            'name' => 'Tuba',
            'is_active' => true
        ]);
        $tuba_i = SubjectBP::create([
            'name' => $tuba->name . ' - Individual',
            'speciality_id' => $tuba->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $tuba_c = SubjectBP::create([
            'name' => $tuba->name . ' - Colectiva',
            'speciality_id' => $tuba->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $violonchelo = SpecialityBP::create([
            'name' => 'Violonchelo',
            'is_active' => true
        ]);
        $violonchelo_i = SubjectBP::create([
            'name' => $violonchelo->name . ' - Individual',
            'speciality_id' => $violonchelo->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $violonchelo_c = SubjectBP::create([
            'name' => $violonchelo->name . ' - Colectiva',
            'speciality_id' => $violonchelo->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $contrabajo = SpecialityBP::create([
            'name' => 'Contrabajo',
            'is_active' => true
        ]);
        $contrabajo_i = SubjectBP::create([
            'name' => $contrabajo->name . ' - Individual',
            'speciality_id' => $contrabajo->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $contrabajo_c = SubjectBP::create([
            'name' => $contrabajo->name . ' - Colectiva',
            'speciality_id' => $contrabajo->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $viola = SpecialityBP::create([
            'name' => 'Viola',
            'is_active' => true
        ]);
        $viola_i = SubjectBP::create([
            'name' => $viola->name . ' - Individual',
            'speciality_id' => $viola->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $viola_c = SubjectBP::create([
            'name' => $viola->name . ' - Colectiva',
            'speciality_id' => $viola->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);

        $percusion = SpecialityBP::create([
            'name' => 'Percusión',
            'is_active' => true
        ]);
        $percusion_i = SubjectBP::create([
            'name' => $percusion->name . ' - Individual',
            'speciality_id' => $percusion->id,
            'is_collective' => false,
            'student_ratio' => 1,
            'is_active' => true,
        ]);
        $percusion_c = SubjectBP::create([
            'name' => $percusion->name . ' - Colectiva',
            'speciality_id' => $percusion->id,
            'is_collective' => true,
            'student_ratio' => 8,
            'is_active' => true,
        ]);


        // Crear un plan de estudios: 1º enseñanzas elementales de música (eem)
        $syllabi_1eem = SyllabiBP::create([
            // El nombre del plan de estudios.
            'name' => '',

            // La edad del plan de estudios
            'age' => '8',

            // Asignaturas que se pueden suspender para aprobar el curso.
            'max_failed_subjects_to_pass' => '2',

            // El ID del curso que hemos creado anteriormente.
            'course_id' => $primero->id,

            // El ID del grado que hemos creado anteriormente.
            'degree_id' => $elemental->id,
        ]);

        // Asignar especialidades al plan de estudios
        $syllabi_1eem->specialities()->attach([$piano->id, $violin->id, $clarinete->id, $trompeta->id]);

        // Asignar asignaturas al plan de estudios
        // MUY importante, asignar las asignaturas de especialidad correspondientes.
        $syllabi_1eem->subjects()->attach([
            // Asignatura coro, con sus propiedades.
            // Importante, la asignatura coro, no pertenece a ninguna especialidad, 
            // por lo que (is_speciality = false)
            $coro->id => [
                'is_mandatory' => true,
                'school_hours' => 12.5,
                'price' => 50.00,
                'is_speciality' => false,
                'student_ratio' => 10,
            ],

            $lenguaje_musical->id => [
                'is_mandatory' => true,
                'school_hours' => 12.5,
                'price' => 50.00,
                'is_speciality' => false,
                'student_ratio' => 10,
            ],            

            // Asignatura piano_i (Piano - Individual), con sus propiedades.
            // Importante, la asignatura piano_i, pertenece a una especialidad,
            // por lo que (is_speciality = true)
            // Y el ratio de estudiantes, el mismo que el de la asignatura.
            $piano_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $piano_i->student_ratio,
            ],

            // Asignatura piano_c (Piano - Colectiva), con sus propiedades.
            // Importante, la asignatura piano_c, pertenece a una especialidad,
            // por lo que (is_speciality = true)
            // Y el ratio de estudiantes, el mismo que el de la asignatura.
            $piano_c->id => [
                'is_mandatory' => true,
                'school_hours' => 18.5,
                'price' => 80.00,
                'is_speciality' => true,
                'student_ratio' => $piano_c->student_ratio,
            ],

            $violin_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $violin_i->student_ratio,
            ],
            
            $violin_c->id => [
                'is_mandatory' => true,
                'school_hours' => 18.5,
                'price' => 80.00,
                'is_speciality' => true,
                'student_ratio' => $violin_c->student_ratio,
            ],

            $clarinete_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $clarinete_i->student_ratio,
            ],
            
            $clarinete_c->id => [
                'is_mandatory' => true,
                'school_hours' => 18.5,
                'price' => 80.00,
                'is_speciality' => true,
                'student_ratio' => $clarinete_c->student_ratio,
            ],

            $trompeta_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $trompeta_i->student_ratio,
            ],
            
            $trompeta_c->id => [
                'is_mandatory' => true,
                'school_hours' => 18.5,
                'price' => 80.00,
                'is_speciality' => true,
                'student_ratio' => $trompeta_c->student_ratio,
            ],
        ]);

        // Crear un plan de estudios: 1º enseñanzas profesionales de música (epm)
        $syllabi_1epm = SyllabiBP::create([
            'name' => '1EPM',
            'age' => '11',
            'max_failed_subjects_to_pass' => '2',
            'course_id' => $primero->id,
            'degree_id' => $profesional->id,
        ]);

        // Asignar especialidades al plan de estudios
        $syllabi_1epm->specialities()->attach([$fagot->id, $flauta->id, $clarinete->id, $trompeta->id, $saxofon->id]);

        // Asignar asignaturas al plan de estudios
        $syllabi_1epm->subjects()->attach([
            $armonia->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 105.00,
                'is_speciality' => false,
                'student_ratio' => $armonia->student_ratio,
            ],
            $musica_camara->id => [
                'is_mandatory' => true,
                'school_hours' => 12.5,
                'price' => 50.00,
                'is_speciality' => false,
                'student_ratio' => $musica_camara->student_ratio,
            ],

            $banda->id => [
                'is_mandatory' => true,
                'school_hours' => 12.5,
                'price' => 50.00,
                'is_speciality' => false,
                'student_ratio' => $banda->student_ratio,
            ],

            $fagot_i->id => [
                'is_mandatory' => true,
                'school_hours' => 18.5,
                'price' => 150.00,
                'is_speciality' => true,
                'student_ratio' => $fagot_i->student_ratio,
            ],
            $flauta_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $flauta_i->student_ratio,
            ],
            
            $clarinete_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $clarinete_i->student_ratio,
            ],
            
            $trompeta_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $trompeta_i->student_ratio,
            ],

            $saxofon_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $saxofon_i->student_ratio,
            ],
            
        ]);

        // Crear un plan de estudios: 4º profesional
        $syllabi_4epm = SyllabiBP::create([
            'name' => '',
            'age' => '14',
            'max_failed_subjects_to_pass' => '2',
            'course_id' => $cuarto->id,
            'degree_id' => $profesional->id,
        ]);

        // Asignar especialidades al plan de estudios
        $syllabi_4epm->specialities()->attach([$violonchelo->id, $violin->id, $contrabajo->id, $viola->id]);

        // Asignar asignaturas al plan de estudios
        $syllabi_4epm->subjects()->attach([
            $armonia->id => [
                'is_mandatory' => true,
                'school_hours' => 12.5,
                'price' => 50.00,
                'is_speciality' => false,
                'student_ratio' => 10,
            ],
            $orquesta->id => [
                'is_mandatory' => true,
                'school_hours' => 12.5,
                'price' => 50.00,
                'is_speciality' => false,
                'student_ratio' => $orquesta->student_ratio,
            ],
            $musica_camara->id => [
                'is_mandatory' => true,
                'school_hours' => 12.5,
                'price' => 50.00,
                'is_speciality' => false,
                'student_ratio' => $musica_camara->student_ratio,
            ],
            $violonchelo_i->id => [
                'is_mandatory' => true,
                'school_hours' => 18.5,
                'price' => 150.00,
                'is_speciality' => true,
                'student_ratio' => $violonchelo_i->student_ratio,
            ],

            $violin_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $violin_i->student_ratio,
            ],
            
            $contrabajo_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $contrabajo_i->student_ratio,
            ],
            
            $viola_i->id => [
                'is_mandatory' => true,
                'school_hours' => 15.5,
                'price' => 75.00,
                'is_speciality' => true,
                'student_ratio' => $viola_i->student_ratio,
            ],
        ]);
        
    }
}
