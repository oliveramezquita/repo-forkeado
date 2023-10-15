<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Teacher diary
        Permission::create(['name' => 'teacher.diary.show']);
        // Permission::create(['name' => 'teacher.diary.update']);
        // Permission::create(['name' => 'teacher.diary.destroy']);
        // Permission::create(['name' => 'teacher.diary.activate']);

        // Teacher signature
        Permission::create(['name' => 'teacher.signature.show']);
        // Permission::create(['name' => 'teacher.signature.update']);
        // Permission::create(['name' => 'teacher.signature.destroy']);
        // Permission::create(['name' => 'teacher.signature.activate']);
    }
}
