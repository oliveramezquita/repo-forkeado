<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Student list
        Permission::create(['name' => 'student.show']);
        // Permission::create(['name' => 'student.update']);
        // Permission::create(['name' => 'student.destroy']);
        // Permission::create(['name' => 'student.activate']);

        // Student register
        Permission::create(['name' => 'student.register.show']);
        // Permission::create(['name' => 'student.register.update']);
        // Permission::create(['name' => 'student.register.destroy']);
        // Permission::create(['name' => 'student.register.activate']);

        // Student applications
        Permission::create(['name' => 'student.request.show']);
        // Permission::create(['name' => 'student.request.update']);
        // Permission::create(['name' => 'student.request.destroy']);
        // Permission::create(['name' => 'student.request.activate']);


    }
}
