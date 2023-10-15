<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            // El usuario (profesor) que está a cargo del departamento.
            // Aqui poner siempre 2 (Teacher User), o dejarlo vacio (no ponerlo o poner null).
            'in_charge' => 2,

            // El nombre del departamento.
            'name' => 'Cuerda sinfónica',

            // La descripción del departamento.
            'desc' => 'Instrumentos de cuerda sinfónica',

            // El color del departamento.
            'color' => '#343541',

            // El día de la semana que se reune el departamento.
            // Siendo 1 - Lunes, 2 - Martes, 3 - Miercoles, 4 - Jueves, 5 - Viernes.
            'meeting_day' => '3',

            // La hora a la que se reune el departamento.
            'meeting_time' => '11:30',

            // Si el departamento está activo o no (ponerlo siempre a true).
            'is_active' => true
        ]);

        Department::create([
            'in_charge' => 2,
            'name' => 'Cuerda pulsada',
            'desc' => 'Instrumentos de cuerda pulsada',
            'color' => '#243541',
            'meeting_day' => '3',
            'meeting_time' => '11:30',
            'is_active' => true
        ]);

        Department::create([
            'in_charge' => null,
            'name' => 'Viento-madera',
            'desc' => 'Instrumentos de viento-madera',
            'color' => '#B31F3D',
            'meeting_day' => '3',
            'meeting_time' => '11:30',
            'is_active' => true
        ]);

        Department::create([
            'in_charge' => null,
            'name' => 'Viento-metal',
            'desc' => 'Instrumentos de viento metal',
            'color' => '#00A353',
            'meeting_day' => '3',
            'meeting_time' => '11:30',
            'is_active' => true
        ]);

        Department::create([
            'in_charge' => 2,
            'name' => 'Lenguaje musical',
            'desc' => 'Lenguaje musical',
            'color' => '#10A353',
            'meeting_day' => '3',
            'meeting_time' => '11:30',
            'is_active' => true
        ]);

        Department::create([
            'in_charge' => 2,
            'name' => 'Formaciones grupales',
            'desc' => 'Formaciones grupales',
            'color' => '#1235D3',
            'meeting_day' => '3',
            'meeting_time' => '11:30',
            'is_active' => true
        ]);

        Department::create([
            'in_charge' => 2,
            'name' => 'Tecla',
            'desc' => 'Instrumentos de tecla',
            'color' => '#00A67D',
            'meeting_day' => '3',
            'meeting_time' => '11:30',
            'is_active' => true
        ]);

        Department::create([
            'in_charge' => 2,
            'name' => 'Composición',
            'desc' => 'Fundamentos de composición',
            'color' => '#55A67D',
            'meeting_day' => '3',
            'meeting_time' => '11:30',
            'is_active' => true
        ]);

        Department::create([
            'in_charge' => 2,
            'name' => 'Música antigua',
            'desc' => 'Música antigua',
            'color' => '#95A99D',
            'meeting_day' => '3',
            'meeting_time' => '11:30',
            'is_active' => true
        ]);

        Department::create([
            'in_charge' => 2,
            'name' => 'Canto',
            'desc' => 'Canto',
            'color' => '#40A09D',
            'meeting_day' => '3',
            'meeting_time' => '11:30',
            'is_active' => true
        ]);
    }
}
