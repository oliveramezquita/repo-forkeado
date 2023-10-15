<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UtilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Calendar
        Permission::create(['name' => 'utility.calendar.show']);
        // Permission::create(['name' => 'utility.calendar.update']);
        // Permission::create(['name' => 'utility.calendar.destroy']);
        // Permission::create(['name' => 'utility.calendar.activate']);

        // Schedule
        Permission::create(['name' => 'utility.schedule.show']);
        // Permission::create(['name' => 'utility.schedule.update']);
        // Permission::create(['name' => 'utility.schedule.destroy']);
        // Permission::create(['name' => 'utility.schedule.activate']);

        // Repository
        Permission::create(['name' => 'utility.repository.show']);
        // Permission::create(['name' => 'utility.repository.update']);
        // Permission::create(['name' => 'utility.repository.destroy']);
        // Permission::create(['name' => 'utility.repository.activate']);

        // Incidence
        Permission::create(['name' => 'utility.incidence.show']);
        // Permission::create(['name' => 'utility.incidence.update']);
        // Permission::create(['name' => 'utility.incidence.destroy']);
        // Permission::create(['name' => 'utility.incidence.activate']);

        // Classroom
        Permission::create(['name' => 'utility.classroom.show']);
        // Permission::create(['name' => 'utility.classroom.update']);
        // Permission::create(['name' => 'utility.classroom.destroy']);
        // Permission::create(['name' => 'utility.classroom.activate']);

        // History
        Permission::create(['name' => 'utility.log.show']);
        // Permission::create(['name' => 'utility.log.update']);
        // Permission::create(['name' => 'utility.log.destroy']);
        // Permission::create(['name' => 'utility.log.activate']);

        // Assistance
        Permission::create(['name' => 'utility.assistance.show']);
        // Permission::create(['name' => 'utility.assistance.update']);
        // Permission::create(['name' => 'utility.assistance.destroy']);
        // Permission::create(['name' => 'utility.assistance.activate']);
    }
}
