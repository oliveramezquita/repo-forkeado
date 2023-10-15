<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Evaluation list
        Permission::create(['name' => 'evaluation.show']);
        // Permission::create(['name' => 'evaluation.update']);
        // Permission::create(['name' => 'evaluation.destroy']);
        // Permission::create(['name' => 'evaluation.activate']);

        // Evaluation session
        Permission::create(['name' => 'evaluation.session.show']);
        // Permission::create(['name' => 'evaluation.session.update']);
        // Permission::create(['name' => 'evaluation.session.destroy']);
        // Permission::create(['name' => 'evaluation.session.activate']);

        // Evaluation statistics
        Permission::create(['name' => 'evaluation.statistic.show']);
        // Permission::create(['name' => 'evaluation.statistic.update']);
        // Permission::create(['name' => 'evaluation.statistic.destroy']);
        // Permission::create(['name' => 'evaluation.statistic.activate']);
    }
}
