<?php

namespace Database\Seeders;

use App\Models\Staff\Position;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'name' => 'RMI',
            'description' => 'Responsable de Medios Informáticos',
            'hours' => '-6',
        ]);
    }
}
