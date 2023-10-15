<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SyllabiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Courses
        Permission::create(['name' => 'course.store']);
        Permission::create(['name' => 'course.update']);
        Permission::create(['name' => 'course.destroy']);
        Permission::create(['name' => 'course.activate']);

        // Degrees
        Permission::create(['name' => 'degree.store']);
        Permission::create(['name' => 'degree.update']);
        Permission::create(['name' => 'degree.destroy']);
        Permission::create(['name' => 'degree.activate']);

        // Specialty
        Permission::create(['name' => 'speciality.store']);
        Permission::create(['name' => 'speciality.update']);
        Permission::create(['name' => 'speciality.destroy']);
        Permission::create(['name' => 'speciality.activate']);

        // Subject
        Permission::create(['name' => 'subject.store']);
        Permission::create(['name' => 'subject.update']);
        Permission::create(['name' => 'subject.destroy']);
        Permission::create(['name' => 'subject.activate']);

        // Syllabi
        Permission::create(['name' => 'syllabi.elements.show']);
        Permission::create(['name' => 'syllabi.show']);    
        Permission::create(['name' => 'syllabi.store']);
        Permission::create(['name' => 'syllabi.update']);
        Permission::create(['name' => 'syllabi.destroy']);
        Permission::create(['name' => 'syllabi.activate']);
    }
}
